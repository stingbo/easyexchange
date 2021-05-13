<?php

namespace EasyExchange\Huobi\Socket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Socket\BaseClient;
use EasyExchange\Kernel\Socket\Handle;
use GlobalData\Client as GlobalClient;
use GlobalData\Server;
use Workerman\Timer;
use Workerman\Worker;

class Client extends BaseClient
{
    public $client_type = 'houbi';

    public function getClientType(): string
    {
        return $this->client_type;
    }

    public $auth_channel = [
        'orders', 'trade.clearing', 'accounts.update',
    ];

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
                $worker = new Worker();
                $worker->onWorkerStart = function () use ($params, $link, $handle) {
                    $this->client = new GlobalClient(($this->config['websocket']['ip'] ?? '127.0.0.1').':'.($this->config['websocket']['port'] ?? 2207));
                    $ws_connection = $handle->getConnection($this->config, $link);
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
            }
        }

        Worker::runAll();
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
        $this->updateOrCreate($this->client_type.'_sub', $params);
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
        $this->updateOrCreate($this->client_type.'_unsub', $params);
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
                $channels = array_unique(array_column($subs, 'sub'));
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
        return true;
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
            // check if this channel is subscribed
            $old_subs = $this->get($this->client_type.'_sub_old');
            $channels = array_column($old_subs, 'sub');
            if ($channels && in_array($subs['sub'], $channels)) {
                $this->delete($this->client_type.'_sub');

                return true;
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

            $old_subs = $this->get($this->client_type.'_sub_old');
            foreach ($old_subs as $key => $old_sub) {
                if ($old_sub['sub'] == $unsubs['unsub']) {
                    unset($old_subs[$key]);
                }
            }
            // update sub channel data
            if ($old_subs) {
                $this->updateOrCreate($this->client_type.'_sub_old', $old_subs);
            } else {
                $this->updateOrCreate($this->client_type.'_sub_old', []);
            }
        }

        return true;
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
            // check if this channel is subscribed
            $old_subs = $this->get($this->client_type.'_sub_old');
            $channels = array_column($old_subs, 'sub');
            if ($channels && in_array($subs['sub'], $channels)) {
                $this->delete($this->client_type.'_sub');

                return true;
            }

            // need auth
            if (!$this->isAuth()) {
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

            $old_subs = $this->get($this->client_type.'_sub_old');
            foreach ($old_subs as $key => $old_sub) {
                if ($old_sub['sub'] == $unsubs['unsub']) {
                    unset($old_subs[$key]);
                }
            }
            // update sub channel data
            if ($old_subs) {
                $this->updateOrCreate($this->client_type.'_sub_old', $old_subs);
            } else {
                $this->updateOrCreate($this->client_type.'_sub_old', []);
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
     * auth.
     *
     * @param $connection
     */
    public function auth($connection)
    {
        date_default_timezone_set('UTC');
        $timestamp = date('Y-m-d\TH:i:s');
        $params = [
            'accessKey' => $this->config['app_key'],
            'signatureMethod' => 'HmacSHA256',
            'signatureVersion' => '2.1',
            'timestamp' => $timestamp,
        ];
        $sign = $this->getSignature($params);
        $params['authType'] = 'api';
        $params['signature'] = $sign;
        $params = [
            'action' => 'req',
            'ch' => 'auth',
            'params' => $params,
        ];
        $connection->send(json_encode($params));
    }

    /**
     * get sign.
     *
     * @param array  $params
     * @param string $method
     * @param string $uri_host
     * @param string $uri_path
     *
     * @return string
     */
    public function getSignature($params = [], $method = 'GET', $uri_host = 'api.huobi.pro', $uri_path = '/ws/v2')
    {
        ksort($params);
        $data = http_build_query($params);

        $sign_param = $method."\n".$uri_host."\n".$uri_path."\n".$data;
        $secret = $this->config['secret'];
        $signature = hash_hmac('sha256', $sign_param, $secret, true);

        return base64_encode($signature);
    }
}
