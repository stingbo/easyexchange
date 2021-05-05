<?php

namespace EasyExchange\Okex\Websocket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Websocket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $ws_base_uri = $config['websocket']['base_uri'].'/ws/v5/public';
        echo $ws_base_uri.PHP_EOL;

        $connection = new AsyncTcpConnection($ws_base_uri);
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
        echo 'msg:------------------';
        echo $data.PHP_EOL;
        if ('pong' == $data) {
            return true;
        }

        // save login result
        $result = josn_decode($data, true) ?? [];
        if (isset($result['event']) && 'login' == $result['event'] && 0 == $result['code']) {
            $client->okex_is_auth = 1;
        }

        $old_value = $client->okex_data ?? [];
        if (!$old_value) {
            $client->add('okex_data', [$data]);
        } else {
            $max_size = $this->config['websocket']['max_size'] ?? 100;
            $max_size = ($max_size > 1000 || $max_size <= 0) ? 100 : $max_size;
            do {
                $new_value = $old_value;
                if (count($new_value) >= $max_size) {
                    array_unshift($new_value, $data);
                    array_pop($new_value);
                } else {
                    array_unshift($new_value, $data);
                }
            } while (!$client->cas('okex_data', $old_value, $new_value));
        }
    }

    public function onError($connection, $client, $code, $message)
    {
        echo 'error---------: code:'.$code.",message:$message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed\n";
    }

    /**
     * login.
     *
     * @param $connection
     */
    public function login($connection)
    {
        $timestamp = time();
        $sign = $this->getSignature($timestamp);
        $params = [
            'op' => 'login',
            'args' => [
                [
                    'apiKey' => $this->config['app_key'],
                    'passphrase' => $this->config['passphrase'],
                    'timestamp' => $timestamp,
                    'sign' => $sign,
                ],
            ],
        ];
        $connection->send(json_encode($params));
    }

    /**
     * get sign.
     *
     * @param $timestamp
     * @param string $method
     * @param string $uri_path
     *
     * @return string
     */
    public function getSignature($timestamp, $method = 'GET', $uri_path = '/users/self/verify')
    {
        $message = (string) $timestamp.$method.$uri_path;
        $secret = $this->config['secret'];

        return base64_encode(hash_hmac('sha256', $message, $secret, true));
    }
}
