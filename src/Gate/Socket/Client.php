<?php

namespace EasyExchange\Gate\Socket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Socket\BaseClient;
use Workerman\Timer;
use Workerman\Worker;

class Client extends BaseClient
{
    public $client_type = 'gate';

    /**
     * This channel requires authentication.
     *
     * @var string[]
     */
    public $auth_channel = [
        'spot.orders', 'spot.usertrades', 'spot.balances',
        'spot.margin_balances', 'spot.funding_balances',
    ];

    public function getClientType(): string
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
        if ('subscribe' != $params['event']) {
            throw new InvalidArgumentException('Invalid argument about event type');
        }
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
        if ('unsubscribe' != $params['event']) {
            throw new InvalidArgumentException('Invalid argument about event type');
        }

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
                $channels = array_unique(array_column($subs, 'channel'));
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
     *
     * @throws \Exception
     */
    public function sub($connection)
    {
        $subs = $this->get($this->client_type.'_sub');
        if ($this->debug) {
            print_r($subs);
        }
        if (!$subs) {
            return true;
        } else {
            if (!isset($subs['channel']) || !$subs['channel']) {
                return true;
            }

            // check if this channel and payload is subscribed
            $old_subs = $this->get($this->client_type.'_sub_old');
            if ($old_subs && ($payloads = array_column($old_subs, 'payload', 'channel'))) {
                foreach ($payloads as $channel => $payload) {
                    if ($subs['channel'] == $channel && !($sub_payload = (array_diff($subs['payload'], $payload)))) {
                        $this->delete($this->client_type.'_sub');

                        return true;
                    }
                }
            }

            if (in_array($subs['channel'], $this->auth_channel)) {
                $subs['auth'] = [
                    'method' => 'api_key',
                    'KEY' => $this->config['app_key'],
                    'SIGN' => $this->getSignature($subs['channel'], $subs['event'], $subs['time']),
                ];
            }

            $connection->send(json_encode($subs));
            $this->delete($this->client_type.'_sub');

            if (!$old_subs) {
                $old_subs[] = $subs;
            } else {
                $is_channel_sub = false;
                foreach ($old_subs as &$old_sub) {
                    if ($subs['channel'] == $old_sub['channel']) {
                        $is_channel_sub = true;
                        $old_sub['payload'] = array_values(array_unique(array_merge($old_sub['payload'], $subs['payload'])));
                    }
                }
                unset($old_sub);
                if (!$is_channel_sub) {
                    $old_subs[] = $subs;
                }
            }
            if ($this->debug) {
                print_r($old_subs);
            }
            $this->update($this->client_type.'_sub_old', $old_subs);
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
        $unsubs = $this->get($this->client_type.'_unsub');
        if (!$unsubs) {
            return true;
        } else {
            $old_subs = $this->get($this->client_type.'_sub_old');
            if (!$old_subs) {
                return true;
            }

            $connection->send(json_encode($unsubs));

            foreach ($old_subs as $key => &$old_sub) {
                if ($unsubs['channel'] == $old_sub['channel']) {
                    $payload = array_diff($old_sub['payload'], $unsubs['payload']);
                    if ($payload) {
                        $old_sub['payload'] = $payload;
                        break;
                    } else {
                        unset($old_subs[$key]);
                        break;
                    }
                }
            }
            unset($old_sub);
            $this->updateOrCreate($this->client_type.'_sub_old', $old_subs);

            $this->delete($this->client_type.'_unsub');
        }

        return true;
    }

    /**
     * get sign.
     *
     * @param string $channel   channel
     * @param string $event     event
     * @param int    $timestamp timestamp
     */
    public function getSignature(string $channel, string $event, int $timestamp): string
    {
        $message = sprintf('channel=%s&event=%s&time=%d', $channel, $event, $timestamp);
        $secret = $this->config['secret'];

        return hash_hmac('sha512', $message, $secret);
    }
}
