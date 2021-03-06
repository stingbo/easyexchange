<?php

namespace EasyExchange\Binance\Socket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Socket\BaseClient;
use Workerman\Timer;
use Workerman\Worker;

class Client extends BaseClient
{
    public $client_type = 'binance';

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
        if ('SUBSCRIBE' != $params['method']) {
            throw new InvalidArgumentException('Invalid argument about method type');
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
        if ('UNSUBSCRIBE' != $params['method']) {
            throw new InvalidArgumentException('Invalid argument about method type');
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
                $channels = array_unique(array_column($subs['params'] ?? [], 'channel'));
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
            $connection->send('pong');
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
            if (!isset($subs['params']) || !$subs['params']) {
                return true;
            }

            // check if this channel is subscribed
            $old_subs = $this->get($this->client_type.'_sub_old');
            $old_sub_channels = [];
            foreach ($old_subs as $old_sub) {
                $old_sub_channels = array_values(array_unique(array_merge($old_sub_channels, $old_sub['params'])));
            }
            if ($old_sub_channels) {
                foreach ($subs['params'] as $key => $channel) {
                    if (in_array($channel, $old_sub_channels)) {
                        unset($subs['params'][$key]);
                    }
                }
                if (!$subs['params']) {
                    $this->delete($this->client_type.'_sub');

                    return true;
                }
            }

            $connection->send(json_encode($subs));
            $this->delete($this->client_type.'_sub');

            $this->updateOrCreate($this->client_type.'_id_'.$subs['id'], $subs);
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

            foreach ($old_subs as $key => &$old_sub) {
                $old_sub['params'] = array_values(array_unique(array_diff($old_sub['params'], $unsubs['params'])));
                if (!$old_sub['params']) {
                    unset($old_subs[$key]);
                }
            }
            unset($old_sub);
            if ($old_subs) {
                $this->updateOrCreate($this->client_type.'_sub_old', $old_subs);
            } else {
                $this->updateOrCreate($this->client_type.'_sub_old', []);
            }
        }

        return true;
    }
}
