<?php

namespace EasyExchange\Gate\Socket;

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
        echo 'connect gate:-----------------'.PHP_EOL;
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $client, $params, $data)
    {
        echo $data.PHP_EOL;
//        {"time":1620567501,"channel":"spot.trades","event":"subscribe","result":{"status":"success"}}
//        {"time":1620568169,"channel":"spot.trades","event":"update","result":{"id":949254431,"create_time":1620568169,"create_time_ms":"1620568169005.6711","side":"sell","currency_pair":"BTC_USDT","amount":"0.0072000000","price":"57144.2000000000"}}
        $result = json_decode($data, true) ?? [];
        // save data by channel
        if ($result && is_array($result) && isset($result['event']) && isset($result['result'])) {
            $channel = $result['channel'] ?? '';
            if (!$channel) {
                return true;
            }
            $key = 'gate_list_'.$channel;
            $old_list = $client->{$key} ?? [];
            if (!$old_list) {
                $client->add($key, [$data]);
            } else {
                $max_size = $this->config['websocket']['max_size'] ?? 100;
                $max_size = ($max_size > 1000 || $max_size <= 0) ? 100 : $max_size;
                do {
                    $new_list = $old_list = $client->{$key};
                    if (count($new_list) >= $max_size) {
                        array_unshift($new_list, $data);
                        array_pop($new_list);
                    } else {
                        array_unshift($new_list, $data);
                    }
                } while (!$client->cas($key, $old_list, $new_list));
            }
        }

        return true;
    }

    public function onError($connection, $client, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed，now reconnect\n";
        $connection->reConnect(1);

        $client->gate_sub = $client->gate_sub_old;
        $client->gate_sub_old = [];
    }
}
