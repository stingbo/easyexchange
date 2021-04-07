<?php

namespace EasyExchange\Huobi\Websocket;

use EasyExchange\Kernel\WebsocketClient;

class Client extends WebsocketClient
{
    /**
     * Live Subscribing to streams.
     *
     * @param $params
     */
    public function subscribe($params, callable $f)
    {
        $this->request('/ws', $params, $f);
    }
}
