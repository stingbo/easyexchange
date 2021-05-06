<?php

namespace EasyExchange\Okex\Socket;

use Workerman\Connection\AsyncTcpConnection;

class Handle implements \EasyExchange\Kernel\Socket\Handle
{
    private $config;

    public function getConnection($config, $params)
    {
        $this->config = $config;

        if (isset($params['private']) && $params['private']) {
            $ws_base_uri = $config['websocket']['base_uri'].'/ws/v5/private';
        } else {
            $ws_base_uri = $config['websocket']['base_uri'].'/ws/v5/public';
        }
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
        echo 'msg:--------------------------------'.PHP_EOL;
        echo $data.PHP_EOL;
        if ('pong' == $data) {
            return true;
        }

        // save login result
        $result = json_decode($data, true) ?? [];
        if (isset($result['event'])) {
            if ('login' == $result['event'] && 0 == $result['code']) {
                $client->okex_is_auth = 1;
            } elseif ('subscribe' == $result['event']) {
                $old_subs = $client->okex_sub_old ?? [];
                if (!$old_subs) {
                    $client->okex_sub_old = ['op' => 'subscribe', 'args' => [$result['arg']]];
                } else {
                    if (!in_array($result['arg'], $old_subs['args'])) {
                        do {
                            $new_subs = $old_subs = $client->okex_sub_old;
                            $new_subs['args'][] = $result['arg'];
                        } while (!$client->cas('okex_sub_old', $old_subs, $new_subs));
                    }
                }
            }
        }

        // save data by channel
        if ($result && is_array($result) && isset($result['arg']) && isset($result['data'])) {
            $channel = $result['arg']['channel'] ?? '';
            if (!$channel) {
                return true;
            }
            $key = 'okex_list_'.$channel;
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
        echo 'error---------: code:'.$code.",message:$message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed，now reconnect\n";
        $connection->reConnect(1);

        $public = [];
        $private = [];
        $subs = $client->okex_sub_old;
        foreach ($subs['args'] as $arg) {
            if (in_array($arg['channel'], $this->config['auth_channel'])) {
                $private[] = $arg;
            } else {
                $public[] = $arg;
            }
        }
        $client->okex_sub_old = [];

        if ($public) {
            $client->okex_sub = ['op' => 'subscribe', 'args' => $public];
        }
        if ($private) {
            $client->okex_sub_private = ['op' => 'subscribe', 'args' => $private];
        }
    }
}
