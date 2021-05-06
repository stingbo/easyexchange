<?php

namespace EasyExchange\Binance\Socket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Socket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $base_uri = $config['websocket']['base_uri'].'/ws';
        echo $base_uri.PHP_EOL;

        $connection = new AsyncTcpConnection($base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $client, $params)
    {
        echo 'connect:-----------------'.PHP_EOL;
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $client, $params, $data)
    {
        echo 'msg:--------------------------------'.PHP_EOL;
        echo $data.PHP_EOL;

        return true;
    }

    public function onError($connection, $client, $code, $message)
    {
        echo 'error---------: code:'.$code.",message:$message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed，now reconnect\n";
        $connection->reConnect(1);

        $client->binance_sub = $client->binance_sub_old;
        $client->binance_sub_old = [];
    }
}
