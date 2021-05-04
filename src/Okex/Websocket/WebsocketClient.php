<?php

namespace EasyExchange\Okex\Websocket;

use EasyExchange\Kernel\Exceptions\InvalidArgumentException;
use EasyExchange\Kernel\Support\Arr;
use EasyExchange\Kernel\Websocket\BaseClient;
use Workerman\Timer;

class WebsocketClient extends BaseClient
{
    public $client_type = 'okex';

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
            throw new InvalidArgumentException('Invalid argument about op');
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
            throw new InvalidArgumentException('Invalid argument about op');
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
        $sub_data = $this->get('okex_sub_old');
        print_r($sub_data);
        die;

        return $sub_data;
    }

    public function ping($connection)
    {
        Timer::add(20, function () use ($connection) {
            $connection->send('ping');
        });
    }

    public function connect($connection, $time = 3)
    {
        $connection->timer_id = Timer::add($time, function () use ($connection) {
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
        echo 'sub:----------'.PHP_EOL;
        $subs = $this->get('okex_sub');
        print_r($subs);
        if (!$subs) {
            return true;
        } else {
            $old_subs = $this->get('okex_sub_old');
            // check if this channel is subscribed
            if (isset($subs['args']) && isset($old_subs['args'])) {
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
            } else {
                return true;
            }
            echo 'sub:------------'.PHP_EOL;
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
        echo 'unsub:----------'.PHP_EOL;
        $unsubs = $this->get('okex_unsub');
        print_r($unsubs);
        if (!$unsubs) {
            return true;
        } else {
            echo 'unsub:------------'.PHP_EOL;
            $old_subs = $this->get('okex_sub_old');
            if (!$old_subs) {
                return true;
            }

            $connection->send(json_encode($unsubs));
            $this->delete('okex_unsub');

            print_r($old_subs);
            if (isset($old_subs['args']) && $unsubs['args']) {
                $old_subs['args'] = Arr::diff($old_subs['args'], $unsubs['args']);
                print_r($old_subs);

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
}
