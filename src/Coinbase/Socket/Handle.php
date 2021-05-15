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
        $result = json_decode($data, true) ?? [];
        if (isset($result['type']) && 'subscriptions' == $result['type']) {
            $old_subs = $client->coinbase_sub_old ?? [];
            if (!$old_subs) {
                $client->coinbase_sub_old = $result;
            } else {
                do {
                    $old_subs = $client->coinbase_sub_old;
                } while (!$client->cas('coinbase_sub_old', $old_subs, $result));
            }
        } elseif (isset($result['type']) && 'error' == $result['type']) {
            echo $result['message'].PHP_EOL;
        } elseif (isset($result['type'])) {
            $key = 'coinbase_list_'.$result['type'];
            $old_list = $client->{$key} ?? [];
            if (!$old_list) {
                $client->add($key, $result);
            } else {
                $max_size = $this->config['websocket']['max_size'] ?? 100;
                $max_size = ($max_size > 1000 || $max_size <= 0) ? 100 : $max_size;
                do {
                    $new_list = $old_list = $client->{$key};
                    if (count($new_list) >= $max_size) {
                        array_unshift($new_list, $result);
                        array_pop($new_list);
                    } else {
                        array_unshift($new_list, $result);
                    }
                } while (!$client->cas($key, $old_list, $new_list));
            }
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

        $client->coinbase_sub = $client->coinbase_sub_old;
        $client->coinbase_sub_old = [];
    }
}
