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
                foreach ($old_subs['channels'] as &$old_sub) {
                    foreach ($result['channels'] as $new_sub) {
                        if ($old_sub['name'] == $new_sub['name']) {
                            $old_sub['product_ids'] = array_unique(array_filter(array_merge($old_sub['product_ids'], $new_sub['product_ids'])));
                        }
                    }
                }
                $new_subs = $old_subs;
                do {
                    $old_subs = $client->coinbase_sub_old;
                } while (!$client->cas('coinbase_sub_old', $old_subs, $new_subs));
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
