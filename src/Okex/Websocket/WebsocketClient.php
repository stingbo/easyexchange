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

    public function connect($connection, $client, $time = 3)
    {
        $connection->timer_id = Timer::add($time, function () use ($connection, $client) {
            // subscribe
            $this->sub($connection, $client);

            // unsubscribe
            $this->unSub($connection, $client);
        });
    }

    public function sub($connection, $client)
    {
        echo '----------'.PHP_EOL;
        print_r($client);
        $client = new Client('127.0.0.1:2207');
        print_r($client);
        $channel = $client->add('aaaa', 'bbb');
//        $channel = $this->get('okex');
//        var_dump($channel);
//        if (!$channel) {
//            return true;
//        } else {
        $connection->send(json_encode([]));
//            $this->move('okex', 'okex_old');
//            $this->delete('okex');
//        }

        return true;
    }

    public function unSub($connection, $client)
    {
//        $this->delete('');
    }
}
