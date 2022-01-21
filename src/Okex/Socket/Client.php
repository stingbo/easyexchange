<?php

namespace EasyExchange\Okex\Socket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Socket\BaseClient;
use EasyExchange\Kernel\Socket\Handle;
use EasyExchange\Kernel\Support\Arr;
use GlobalData\Client as GlobalClient;
use GlobalData\Server;
use Workerman\Connection\TcpConnection;
use Workerman\Timer;
use Workerman\Worker;

class Client extends BaseClient
{
    public $client_type = 'okex';

    public $auth_channel = [
        'account', 'positions', 'balance_and_position', // account
        'orders', 'orders-algo', 'order', 'batch-orders', // order & algo order
        'cancel-order', 'batch-cancel-orders', 'amend-order', 'batch-amend-orders', // trade
    ];

    /**
     * Get web socket client type.
     */
    public function getClientType(): string
    {
        return $this->client_type;
    }

    /**
     * Override the parent method.
     *
     * @param $params
     * @param Handle $handle handle
     */
    public function server($params, Handle $handle)
    {
        $this->config['auth_channel'] = $this->auth_channel;

        // GlobalData Server
        new Server($this->config['websocket']['ip'] ?? '127.0.0.1', $this->config['websocket']['port'] ?? 2207);

        if (isset($this->config['websocket']['base_uri']) && is_array($this->config['websocket']['base_uri'])) {
            foreach ($this->config['websocket']['base_uri'] as $link) {
                if ('public' == $link['type']) {
                    $port = 4207;
                } else {
                    $port = 4208;
                }
                $worker = new Worker('websocket://127.0.0.1:'.$port);
                $worker->onWorkerStart = function () use ($params, $link, $handle) {
                    $this->client = new GlobalClient(($this->config['websocket']['ip'] ?? '127.0.0.1').':'.($this->config['websocket']['port'] ?? 2207));
                    $ws_connection = $handle->getConnection($this->config, $link);
                    $ws_connection->onConnect = function ($connection) use ($params, $handle) {
                        $handle->onConnect($connection, $this->client, $params);
                    };
                    $ws_connection->onMessage = function ($connection, $data) use ($params, $handle) {
                        $handle->onMessage($connection, $this->client, $params, $data);
                        $this->sendMessage($data);
                    };
                    $ws_connection->onError = function ($connection, $code, $msg) use ($handle) {
                        $handle->onError($connection, $this->client, $code, $msg);
                    };
                    $ws_connection->onClose = function ($connection) use ($handle) {
                        $handle->onClose($connection, $this->client);
                    };
                    $ws_connection->connect();

                    if ('public' == $link['type']) {
                        // heartbeat
                        $this->ping($ws_connection);

                        // timer action
                        $this->connectPublic($ws_connection);
                    }
                    if ('private' == $link['type']) {
                        // heartbeat
                        $this->ping($ws_connection);

                        // timer action
                        $this->connectPrivate($ws_connection);
                    }
                };
                $worker->con = '';
                $worker->onMessage = function (TcpConnection $connection, $data) use ($worker) {
                    global $worker;
                    if (is_null($worker)) {
                        $worker = (object) [];
                    }
                    $worker->con = $connection;
                    $this->sendMessage($data);
                };
            }
        }

        Worker::runAll();
    }

    public function sendMessage($message)
    {
        global $worker;
        if (isset($worker->con)) {
            $worker->con->send($message);

            return true;
        }

        return false;
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
            $this->updateOrCreate($this->client_type.'_sub', ['op' => 'subscribe', 'args' => $public]);
        }
        if ($private) {
            $this->updateOrCreate($this->client_type.'_sub_private', ['op' => 'subscribe', 'args' => $private]);
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
            $this->updateOrCreate($this->client_type.'_unsub', ['op' => 'unsubscribe', 'args' => $public]);
        }
        if ($private) {
            $this->updateOrCreate($this->client_type.'_unsub_private', ['op' => 'unsubscribe', 'args' => $private]);
        }
    }

    /**
     * Get subscribed channels.
     *
     * @return array|mixed
     */
    public function getSubChannel()
    {
        return $this->get($this->client_type.'_sub_old');
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
            $subs = $this->get($this->client_type.'_sub_old');
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
            $key = $this->client_type.'_list_'.$channel;
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
        $subs = $this->get($this->client_type.'_sub');
        if ($this->debug) {
            echo 'public channel:--------------------'.PHP_EOL;
            print_r($subs);
        }
        if (!$subs) {
            return true;
        } else {
            if (!isset($subs['args']) || !$subs['args']) {
                return true;
            }

            // check if this channel is subscribed
            $old_subs = $this->get($this->client_type.'_sub_old');
            if (isset($old_subs['args'])) {
                foreach ($subs['args'] as $key => $channel) {
                    foreach ($old_subs['args'] as $subed_channel) {
                        if ($channel == $subed_channel) {
                            unset($subs['args'][$key]);
                        }
                    }
                }
                if (!$subs['args']) {
                    $this->delete($this->client_type.'_sub');

                    return true;
                }
            }

            $connection->send(json_encode($subs));
            $this->delete($this->client_type.'_sub');
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
        $unsubs = $this->get($this->client_type.'_unsub');
        if (!$unsubs) {
            return true;
        } else {
            $old_subs = $this->get($this->client_type.'_sub_old');
            if (!$old_subs) {
                return true;
            }

            $connection->send(json_encode($unsubs));
            $this->delete($this->client_type.'_unsub');

            if (isset($old_subs['args']) && $unsubs['args']) {
                $old_subs['args'] = Arr::diff($old_subs['args'], $unsubs['args']);

                // update sub channel data
                if ($old_subs['args']) {
                    $this->updateOrCreate($this->client_type.'_sub_old', $old_subs);
                } else {
                    $this->updateOrCreate($this->client_type.'_sub_old', []);
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
        $subs = $this->get($this->client_type.'_sub_private');
        if ($this->debug) {
            echo 'private channel:--------------------'.PHP_EOL;
            print_r($subs);
        }
        if (!$subs) {
            return true;
        } else {
            if (!isset($subs['args']) || !$subs['args']) {
                return true;
            }

            // check if this channel is subscribed
            $old_subs = $this->get($this->client_type.'_sub_old');
            if (isset($old_subs['args'])) {
                foreach ($subs['args'] as $key => $channel) {
                    foreach ($old_subs['args'] as $subed_channel) {
                        if ($channel == $subed_channel) {
                            unset($subs['args'][$key]);
                        }
                    }
                }
                if (!$subs['args']) {
                    $this->delete($this->client_type.'_sub_private');

                    return true;
                }
            }

            // need login
            if (array_intersect(array_column($subs['args'], 'channel'), $this->auth_channel) && !$this->isAuth()) {
                $this->auth($connection);

                return true;
            }

            $connection->send(json_encode($subs));
            $this->delete($this->client_type.'_sub_private');
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
        $unsubs = $this->get($this->client_type.'_unsub_private');
        if (!$unsubs) {
            return true;
        } else {
            $old_subs = $this->get($this->client_type.'_sub_old');
            if (!$old_subs) {
                return true;
            }

            $connection->send(json_encode($unsubs));
            $this->delete($this->client_type.'_unsub_private');

            if (isset($old_subs['args']) && $unsubs['args']) {
                $old_subs['args'] = Arr::diff($old_subs['args'], $unsubs['args']);

                // update sub channel data
                if ($old_subs['args']) {
                    $this->updateOrCreate($this->client_type.'_sub_old', $old_subs);
                } else {
                    $this->updateOrCreate($this->client_type.'_sub_old', []);
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
        return $this->get($this->client_type.'_is_auth');
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
