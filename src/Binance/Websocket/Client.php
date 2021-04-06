<?php

namespace EasyExchange\Binance\Websocket;

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
        $params['method'] = 'SUBSCRIBE';
        $this->request('/ws', $params, $f);
    }
}
