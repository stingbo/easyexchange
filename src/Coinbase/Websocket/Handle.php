<?php

namespace EasyExchange\Coinbase\Websocket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Websocket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $auth = $params['auth'] ?? false;
        if ($auth) {
            $ws_base_uri = $config['ws_base_uri'];
        } else {
            $ws_base_uri = $config['ws_base_uri'];
        }

        $connection = new AsyncTcpConnection($ws_base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $client, $params)
    {
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
        echo "connection closed\n";
    }
}
