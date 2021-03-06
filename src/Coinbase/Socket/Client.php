<?php

namespace EasyExchange\Coinbase\Socket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Socket\BaseClient;
use Workerman\Timer;
use Workerman\Worker;

class Client extends BaseClient
{
    public $client_type = 'coinbase';

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
        if ('subscribe' != $params['type']) {
            throw new InvalidArgumentException('Invalid argument about type');
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
        if ('unsubscribe' != $params['type']) {
            throw new InvalidArgumentException('Invalid argument about type');
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
                $channels = array_unique(array_column($subs['params'] ?? [], 'channels'));
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
            print_r($subs);
        }
        if (!$subs) {
            return true;
        } else {
            if (!isset($subs['channels']) || !$subs['channels']) {
                return true;
            }

            $new_subs = [];
            foreach ($subs['channels'] as $channel) {
                $product_ids = $subs['product_ids'] ?? [];
                if (is_string($channel)) {
                    $new_subs[] = [
                        'name' => $channel,
                        'product_ids' => $product_ids,
                    ];
                } elseif (is_array($channel)) {
                    $channel['product_ids'] = array_unique(array_merge($channel['product_ids'], $product_ids));
                    $new_subs[] = $channel;
                }
            }

            // check if this channel is subscribed
            $old_subs = $this->get($this->client_type.'_sub_old');
            if ($old_subs && isset($old_subs['channels'])) {
                foreach ($new_subs as $key => &$sub) {
                    foreach ($old_subs['channels'] as $old_sub) {
                        if ($sub['name'] == $old_sub['name']) {
                            $sub['product_ids'] = array_unique(array_filter(array_diff($sub['product_ids'], $old_sub['product_ids'])));
                            if (!$sub['product_ids']) {
                                unset($new_subs[$key]);
                                continue 2;
                            }
                        }
                    }
                }
            }
            if (!$new_subs) {
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
        }

        return true;
    }
}
