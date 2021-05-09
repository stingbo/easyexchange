<?php

namespace EasyExchange\Huobi\Socket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Socket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $base_uri = $config['websocket']['base_uri'].'/ws';

        $connection = new AsyncTcpConnection($base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $client, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $client, $params, $data)
    {
        $json_data = gzdecode($data);
        echo $json_data.PHP_EOL;
        $data = json_decode($json_data, true);
        if (isset($data['ping'])) {
            $connection->send(json_encode(['pong' => $data['ping']]));
        }
    }

    public function onError($connection, $client, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed，now reconnect\n";
        $connection->reConnect(1);

        $client->huobi_sub = $client->huobi_sub_old;
        $client->huobi_sub_old = [];
    }
}
