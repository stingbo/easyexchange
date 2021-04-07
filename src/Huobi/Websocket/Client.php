<?php

namespace EasyExchange\Huobi\Websocket;

use EasyExchange\Kernel\WebsocketClient;

class Client extends WebsocketClient
{
    /**
     * Subscribe to Topic.
     *
     * @param $params
     */
    public function subscribe($params, callable $f)
    {
        $this->request('/ws', $params, $f);
    }
}
