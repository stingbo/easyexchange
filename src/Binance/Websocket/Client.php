<?php

namespace EasyExchange\Binance\Websocket;

use EasyExchange\Kernel\WebsocketClient;

class Client extends WebsocketClient
{
    /**
     * Subscribe to a stream.
     *
     * @param $params
     * @param null $f
     */
    public function subscribe($params, $f = null)
    {
        $params['method'] = 'SUBSCRIBE';

        return $this->request('/ws', $params, $f);
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     * @param null $f
     */
    public function unsubscribe($params, $f = null)
    {
        $params['method'] = 'UNSUBSCRIBE';

        return $this->request('/ws', $params, $f = null);
    }
}
