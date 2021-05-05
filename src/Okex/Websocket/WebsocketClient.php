<?php

namespace EasyExchange\Okex\Websocket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Support\Arr;
use EasyExchange\Kernel\Websocket\BaseClient;
use Workerman\Timer;

class WebsocketClient extends BaseClient
{
    public $client_type = 'okex';

    public $auth_channel = [
        'account', 'positions', 'balance_and_position', // account
        'orders', 'orders-algo', 'order', 'batch-orders', // order & algo order
        'cancel-order', 'batch-cancel-orders', 'amend-order', 'batch-amend-orders', // trade
    ];

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

        $this->updateOrCreate('okex_sub', $params);
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

        $this->updateOrCreate('okex_unsub', $params);
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
     * Get Data.
     *
     * @return array|mixed
     */
    public function getData()
    {
        return $this->get('okex_data');
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
    public function connect($connection)
    {
        $interval = $this->config['websocket']['timer_time'] ?? 3;
        $connection->timer_id = Timer::add($interval, function () use ($connection) {
            // subscribe
            $this->sub($connection);

            // unsubscribe
            $this->unSub($connection);
        });
    }

    /**
     * subscribe.
     *
     * @param $connection
     *
     * @return bool
     */
    public function sub($connection)
    {
        $subs = $this->get('okex_sub');
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

            // need login
            if (array_intersect(array_column($subs['args'], 'channel'), $this->auth_channel) && !$this->isAuth()) {
                $this->auth($connection);
            }

            $connection->send(json_encode($subs));

            // update
            $this->update('okex_sub', $this->get('okex_sub'), $subs);
            // move sub channel to other key
            $this->move('okex_sub', 'okex_sub_old'); // delete sub channel data
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
    public function unSub($connection)
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
