<?php

namespace EasyExchange\Huobi\Socket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Socket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $base_uri = $params['url'];

        $connection = new AsyncTcpConnection($base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $client, $params)
    {
        echo 'connect huobi:-----------------'.PHP_EOL;
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $client, $params, $data)
    {
        if (false !== json_encode($data)) { // is json format
            echo $data.PHP_EOL;
            $result = json_decode($data, true);
        } else {
            $json_data = gzdecode($data);
            echo $json_data.PHP_EOL;
            $result = json_decode($json_data, true);
        }
        // Heartbeat
        if (isset($result['ping'])) {
            $connection->send(json_encode(['pong' => $result['ping']]));

            return true;
        } elseif (isset($result['action']) && 'ping' == $result['action']) {
            $result['action'] = 'pong';
            $connection->send(json_encode($result));

            return true;
        }

        // save subscribe public channel
        if (isset($result['subbed']) && isset($result['status']) && 'ok' == $result['status']) {
            $new_sub = ['id' => $result['id'], 'sub' => $result['subbed']];
            $old_subs = $client->huobi_sub_old ?? [];
            if (!$old_subs) {
                $client->huobi_sub_old = $new_sub;
            } else {
                $channels = array_column($old_subs, 'sub');
                if (!in_array($result['subbed'], $channels)) {
                    do {
                        $new_subs = $old_subs = $client->huobi_sub_old;
                        $new_subs[] = $new_sub;
                    } while (!$client->cas('huobi_sub_old', $old_subs, $new_subs));
                }
            }
        }
        // save subscribe private channel
        if (isset($result['action']) && isset($result['code']) && 200 == $result['code']) {
            $new_sub = ['id' => '', 'sub' => $result['ch']];
            $old_subs = $client->huobi_sub_old ?? [];
            if (!$old_subs) {
                $client->huobi_sub_old = $new_sub;
            } else {
                $channels = array_column($old_subs, 'sub');
                if (!in_array($result['subbed'], $channels)) {
                    do {
                        $new_subs = $old_subs = $client->huobi_sub_old;
                        $new_subs[] = $new_sub;
                    } while (!$client->cas('huobi_sub_old', $old_subs, $new_subs));
                }
            }
        }

        // save data
        if (isset($result['ch'])) {
            $key = 'huobi_list_'.$result['ch'];
            $old_list = $client->{$key} ?? [];
            if (!$old_list) {
                $client->add($key, [$json_data]);
            } else {
                $max_size = $this->config['websocket']['max_size'] ?? 100;
                $max_size = ($max_size > 1000 || $max_size <= 0) ? 100 : $max_size;
                do {
                    $new_list = $old_list = $client->{$key};
                    if (count($new_list) >= $max_size) {
                        array_unshift($new_list, $json_data);
                        array_pop($new_list);
                    } else {
                        array_unshift($new_list, $json_data);
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

        $client->huobi_sub = $client->huobi_sub_old;
        $client->huobi_sub_old = [];
    }
}
