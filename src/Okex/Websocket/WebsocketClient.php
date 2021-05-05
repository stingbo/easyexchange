<?php

namespace EasyExchange\Okex\Websocket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Support\Arr;
use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\Handle;
use GlobalData\Client;
use GlobalData\Server;
use Workerman\Timer;
use Workerman\Worker;

class WebsocketClient extends BaseClient
{
    public $client_type = 'okex';

    public $auth_channel = [
        'account', 'positions', 'balance_and_position', // account
        'orders', 'orders-algo', 'order', 'batch-orders', // order & algo order
        'cancel-order', 'batch-cancel-orders', 'amend-order', 'batch-amend-orders', // trade
    ];

    /**
     * Override the parent method.
     *
     * @param $params
     */
    public function server($params, Handle $handle)
    {
        $worker = new Worker();
        $private_worker = new Worker();
        $this->config['auth_channel'] = $this->auth_channel;

        // GlobalData Server
        new Server($this->config['websocket']['ip'] ?? '127.0.0.1', $this->config['websocket']['port'] ?? 2207);

        $worker->onWorkerStart = function () use ($params, $handle) {
            $this->client = new Client(($this->config['websocket']['ip'] ?? '127.0.0.1').':'.($this->config['websocket']['port'] ?? 2207));
            $ws_connection = $handle->getConnection($this->config, $params);
            $ws_connection->onConnect = function ($connection) use ($params, $handle) {
                $handle->onConnect($connection, $this->client, $params);
            };
            $ws_connection->onMessage = function ($connection, $data) use ($params, $handle) {
                $handle->onMessage($connection, $this->client, $params, $data);
            };
            $ws_connection->onError = function ($connection, $code, $msg) use ($handle) {
                $handle->onError($connection, $this->client, $code, $msg);
            };
            $ws_connection->onClose = function ($connection) use ($handle) {
                $handle->onClose($connection, $this->client);
            };
            $ws_connection->connect();

            // heartbeat
            $this->ping($ws_connection);

            // timer action
            $this->connectPublic($ws_connection);
        };

        $params['private'] = 1;
        $private_worker->onWorkerStart = function () use ($params, $handle) {
            $client = new Client(($this->config['websocket']['ip'] ?? '127.0.0.1').':'.($this->config['websocket']['port'] ?? 2207));
            $ws_connection = $handle->getConnection($this->config, $params);
            $ws_connection->onConnect = function ($connection) use ($params, $handle, $client) {
                $handle->onConnect($connection, $client, $params);
            };
            $ws_connection->onMessage = function ($connection, $data) use ($params, $handle, $client) {
                $handle->onMessage($connection, $client, $params, $data);
            };
            $ws_connection->onError = function ($connection, $code, $msg) use ($handle, $client) {
                $handle->onError($connection, $client, $code, $msg);
            };
            $ws_connection->onClose = function ($connection) use ($handle, $client) {
                $handle->onClose($connection, $client);
            };
            $ws_connection->connect();

            // heartbeat
            $this->ping($ws_connection);

            // timer action
            $this->connectPrivate($ws_connection);
        };

        Worker::runAll();
    }

    public function getClientType()
    {
        return $this->client_type;
    }

    /**
     * Subscribe to a stream.
     *
     * @param $params
     *
     * @throws InvalidArgumentException
     */
    public function subscribe($params)
    {
        if ('subscribe' != $params['op']) {
            throw new InvalidArgumentException('Invalid argument about op type');
        }
        $public = [];
        $private = [];
        foreach ($params['args'] as $arg) {
            if (in_array($arg['channel'], $this->auth_channel)) {
                $private[] = $arg;
            } else {
                $public[] = $arg;
            }
        }

        if ($public) {
            $this->updateOrCreate('okex_sub', ['op' => 'subscribe', 'args' => $public]);
        }
        if ($private) {
            $this->updateOrCreate('okex_sub_private', ['op' => 'subscribe', 'args' => $private]);
        }
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     *
     * @throws InvalidArgumentException
     */
    public function unsubscribe($params)
    {
        if ('unsubscribe' != $params['op']) {
            throw new InvalidArgumentException('Invalid argument about op type');
        }

        $public = [];
        $private = [];
        foreach ($params['args'] as $arg) {
            if (in_array($arg['channel'], $this->auth_channel)) {
                $private[] = $arg;
            } else {
                $public[] = $arg;
            }
        }
        if ($public) {
            $this->updateOrCreate('okex_unsub', ['op' => 'unsubscribe', 'args' => $public]);
        }
        if ($private) {
            $this->updateOrCreate('okex_unsub_private', ['op' => 'unsubscribe', 'args' => $private]);
        }
    }

    /**
     * Get subscribed channels.
     *
     * @return array|mixed
     */
    public function getSubChannel()
    {
        return $this->get('okex_sub_old');
    }

    /**
     * Get Data by Channel.
     *
     * @param array $channels [channel_name ...], default all
     * @param false $daemon
     * @param null  $callback
     *
     * @return array
     */
    public function getChannelData($channels = [], $callback = null, $daemon = false)
    {
        if (!$channels) {
            $subs = $this->get('okex_sub_old');
            if ($subs) {
                $channels = array_unique(array_column($subs['args'] ?? [], 'channel'));
            }
        }

        if ($daemon) {
            $this->getDataWithDaemon($channels, $callback);
        }

        return $this->getData($channels, $callback);
    }

    /**
     * @param array $channels subscribe channel
     * @param null  $callback callback
     */
    public function getDataWithDaemon($channels = [], $callback = null)
    {
        $worker = new Worker();
        $worker->onWorkerStart = function () use ($callback, $channels) {
            $time = $this->config['websocket']['data_time'] ?? 0.1;

            Timer::add($time, function () use ($channels, $callback) {
                $this->getData($channels, $callback);
            });
        };
        Worker::runAll();
    }

    /**
     * Get data.
     *
     * @param array $channels subscribe channel
     * @param null  $callback callback
     *
     * @return array
     */
    protected function getData($channels = [], $callback = null)
    {
        $data = [];
        foreach ($channels as $channel) {
            $key = 'okex_list_'.$channel;
            $data[$channel] = $this->get($key);

            if (null !== $callback) {
                call_user_func_array($callback, [$data[$channel]]);
            }
        }

        return $data;
    }

    /**
     * Heartbeat.
     *
     * @param $connection
     */
    public function ping($connection)
    {
        $interval = $this->config['websocket']['heartbeat_time'] ?? 20;
        Timer::add($interval, function () use ($connection) {
            $connection->send('ping');
        });
    }

    /**
     * Communicate with the server.
     *
     * @param $connection
     */
    public function connectPublic($connection)
    {
        $interval = $this->config['websocket']['timer_time'] ?? 3;
        $connection->timer_id = Timer::add($interval, function () use ($connection) {
            echo 'public:-------------------'.PHP_EOL;
            // subscribe
            $this->subPublic($connection);

            // unsubscribe
            $this->unSubPublic($connection);
        });
    }

    public function connectPrivate($connection)
    {
        $interval = $this->config['websocket']['timer_time'] ?? 3;
        $connection->timer_id = Timer::add($interval, function () use ($connection) {
            echo 'private:-------------------'.PHP_EOL;
            // subscribe
            $this->subPrivate($connection);

            // unsubscribe
            $this->unSubPrivate($connection);
        });
    }

    /**
     * subscribe.
     *
     * @param $connection
     *
     * @return bool
     */
    public function subPublic($connection)
    {
        $subs = $this->get('okex_sub');
        print_r($subs);
        if (!$subs) {
            return true;
        } else {
            if (!isset($subs['args']) || !$subs['args']) {
                return true;
            }

            // check if this channel is subscribed
            $old_subs = $this->get('okex_sub_old');
            if (isset($old_subs['args'])) {
                foreach ($subs['args'] as $key => $channel) {
                    foreach ($old_subs['args'] as $subed_channel) {
                        if ($channel == $subed_channel) {
                            unset($subs['args'][$key]);
                        }
                    }
                }
                if (!$subs['args']) {
                    $this->delete('okex_sub');

                    return true;
                }
            }

            $connection->send(json_encode($subs));
            $this->delete('okex_sub');
        }

        return true;
    }

    /**
     * cancel subscribe.
     *
     * @param $connection
     *
     * @return bool
     */
    public function unSubPublic($connection)
    {
        $unsubs = $this->get('okex_unsub');
        if (!$unsubs) {
            return true;
        } else {
            $old_subs = $this->get('okex_sub_old');
            if (!$old_subs) {
                return true;
            }

            $connection->send(json_encode($unsubs));
            $this->delete('okex_unsub');

            if (isset($old_subs['args']) && $unsubs['args']) {
                $old_subs['args'] = Arr::diff($old_subs['args'], $unsubs['args']);

                // update sub channel data
                if ($old_subs['args']) {
                    $this->updateOrCreate('okex_sub_old', $old_subs);
                } else {
                    $this->updateOrCreate('okex_sub_old', []);
                }
            }
        }

        return true;
    }

    /**
     * subscribe.
     *
     * @param $connection
     *
     * @return bool
     */
    public function subPrivate($connection)
    {
        $subs = $this->get('okex_sub_private');
        print_r($subs);
        if (!$subs) {
            return true;
        } else {
            if (!isset($subs['args']) || !$subs['args']) {
                return true;
            }

            // check if this channel is subscribed
            $old_subs = $this->get('okex_sub_old');
            if (isset($old_subs['args'])) {
                foreach ($subs['args'] as $key => $channel) {
                    foreach ($old_subs['args'] as $subed_channel) {
                        if ($channel == $subed_channel) {
                            unset($subs['args'][$key]);
                        }
                    }
                }
                if (!$subs['args']) {
                    $this->delete('okex_sub_private');

                    return true;
                }
            }

            // need login
            if (array_intersect(array_column($subs['args'], 'channel'), $this->auth_channel) && !$this->isAuth()) {
                $this->auth($connection);

                return true;
            }

            $connection->send(json_encode($subs));
            $this->delete('okex_sub_private');
        }

        return true;
    }

    /**
     * cancel subscribe.
     *
     * @param $connection
     *
     * @return bool
     */
    public function unSubPrivate($connection)
    {
        $unsubs = $this->get('okex_unsub_private');
        if (!$unsubs) {
            return true;
        } else {
            $old_subs = $this->get('okex_sub_old');
            if (!$old_subs) {
                return true;
            }

            $connection->send(json_encode($unsubs));
            $this->delete('okex_unsub_private');

            if (isset($old_subs['args']) && $unsubs['args']) {
                $old_subs['args'] = Arr::diff($old_subs['args'], $unsubs['args']);

                // update sub channel data
                if ($old_subs['args']) {
                    $this->updateOrCreate('okex_sub_old', $old_subs);
                } else {
                    $this->updateOrCreate('okex_sub_old', []);
                }
            }
        }

        return true;
    }

    /**
     * Has it been verified.
     *
     * @return array|mixed
     */
    public function isAuth()
    {
        return $this->get('okex_is_auth');
    }

    /**
     * login.
     *
     * @param $connection
     */
    public function auth($connection)
    {
        $timestamp = time();
        $sign = $this->getSignature($timestamp);
        $params = [
            'op' => 'login',
            'args' => [
                [
                    'apiKey' => $this->config['app_key'],
                    'passphrase' => $this->config['passphrase'],
                    'timestamp' => $timestamp,
                    'sign' => $sign,
                ],
            ],
        ];
        $connection->send(json_encode($params));
    }

    /**
     * get sign.
     *
     * @param $timestamp
     * @param string $method
     * @param string $uri_path
     *
     * @return string
     */
    public function getSignature($timestamp, $method = 'GET', $uri_path = '/users/self/verify')
    {
        $message = (string) $timestamp.$method.$uri_path;
        $secret = $this->config['secret'];

        return base64_encode(hash_hmac('sha256', $message, $secret, true));
    }
}
