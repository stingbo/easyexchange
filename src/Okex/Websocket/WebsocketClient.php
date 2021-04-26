<?php

namespace EasyExchange\Okex\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\Handle;
use GlobalData\Client;

class WebsocketClient extends BaseClient
{
//    public function client()
//    {
//        $client = new Client('127.0.0.1:2207');
//    }

    /**
     * Subscribe to a stream.
     *
     * @param $params
     */
    public function subscribe($params, Handle $handle)
    {
        echo 'aaaa'.PHP_EOL;
//        $params['op'] = 'subscribe';

//        $this->request($params, $handle);
    }

    public function save($key, $value)
    {
        if (!isset($this->client->$key)) {
            $this->add($key, $value);
        } else {
            $this->client->$key = $value;
        }
    }

    protected function add($key, $value)
    {
        $this->client->add($key, $value);

        $this->saveGlobalKey($key);
    }

    public function get($key)
    {
        if (!isset($this->client->{$key}) || empty($this->client->{$key})) {
            return [];
        }

        return $this->client->{$key};
    }

    protected function saveGlobalKey($key)
    {
        do {
            $old_value = $new_value = $this->client->global_key;
            $new_value[$key] = $key;
        } while (!$this->client->cas('global_key', $old_value, $new_value));
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     */
    public function unsubscribe($params, Handle $handle)
    {
        $params['op'] = 'unsubscribe';

        $this->request($params, $handle);
    }
}
