<?php

namespace EasyExchange\Okex\Websocket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Websocket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        $auth = $params['auth'] ?? false;
        if ($auth) {
            $ws_base_uri = $config['ws_base_uri'].'/ws/v5/private';
        } else {
            $ws_base_uri = $config['ws_base_uri'].'/ws/v5/public';
        }
        $ws_base_uri = $config['ws_base_uri'].'/ws/v5/public';
        echo $ws_base_uri.PHP_EOL;

        $connection = new AsyncTcpConnection($ws_base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $params)
    {
        $auth = $params['auth'] ?? false;
        if ($auth) {
            $this->login($connection);
        } else {
            $connection->send(json_encode($params));
        }
    }

    public function onMessage($connection, $params, $data)
    {
        echo $data.PHP_EOL;
        $auth = $params['auth'] ?? false;
        unset($params['auth']);
        $result = json_decode($data, true);
        $code = $result['code'] ?? 0;
        $event = $result['event'] ?? '';
        if ($auth && 0 == $code && 'login' == $event) {
            $connection->send(json_encode($params));
        }
    }

    public function onError($connection, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection)
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
