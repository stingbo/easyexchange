<?php

namespace EasyExchange\Okex\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use GlobalData\Client;
use Workerman\Timer;

class WebsocketClient extends BaseClient
{
    /**
     * Subscribe to a stream.
     *
     * @param $params
     */
    public function subscribe($params)
    {
//        $val = $this->client->okex_old;
//        print_r($val);
        $this->updateOrCreate('okex', $params);
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     */
    public function unsubscribe($params)
    {
        $this->updateOrCreate('okex', $params);
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

    public function sub($connection)
    {
        echo '----------'.PHP_EOL;
        $channel = $this->get('okex');
        print_r($channel);
        if (!$channel) {
            return true;
        } else {
            echo 'sub:------------'.PHP_EOL;
            $connection->send(json_encode($channel));
            $this->move('okex', 'okex_old');
            $this->delete('okex');
        }

        return true;
    }

    public function unSub($connection)
    {
        $this->delete('');
    }
}
