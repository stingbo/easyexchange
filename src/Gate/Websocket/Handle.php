<?php

namespace EasyExchange\Gate\Websocket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Websocket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $auth = $params['auth'] ?? false;
        if ($auth) {
            $ws_base_uri = $config['ws_base_uri'].'/ws/v4/';
        } else {
            $ws_base_uri = $config['ws_base_uri'].'/ws/v4/';
        }

        $connection = new AsyncTcpConnection($ws_base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $params, $data)
    {
        echo $data.PHP_EOL;
    }

    public function onError($connection, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection)
    {
        echo "connection closed\n";
    }
}
