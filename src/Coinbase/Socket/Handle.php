<?php

namespace EasyExchange\Coinbase\Socket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Socket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $base_uri = $config['websocket']['base_uri'];
        echo $base_uri.PHP_EOL;

        $connection = new AsyncTcpConnection($base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $client, $params)
    {
        echo 'connect coinbase:-----------------'.PHP_EOL;
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $client, $params, $data)
    {
        echo $data.PHP_EOL;
    }

    public function onError($connection, $client, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed，now reconnect\n";
        $connection->reConnect(1);

        $client->coinbase_sub = $client->coinbase_sub_old;
        $client->coinbase_sub_old = [];
    }
}
