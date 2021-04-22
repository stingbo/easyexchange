<?php

namespace EasyExchange\Huobi\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\Handle;

class Client extends BaseClient
{
    /**
     * Subscribe to Topic.
     *
     * @param $params
     */
    public function subscribe($params, Handle $handle)
    {
        $this->request($params, $handle);
    }

    /**
     * Unsubscribe.
     *
     * @param $params
     */
    public function unsubscribe($params, Handle $handle)
    {
        $this->request($params, $handle);
    }
}
