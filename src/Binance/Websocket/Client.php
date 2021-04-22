<?php

namespace EasyExchange\Binance\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\Handle;

class Client extends BaseClient
{
    /**
     * Subscribe to a stream.
     *
     * @param $params
     */
    public function subscribe($params, Handle $handle)
    {
        $params['method'] = 'SUBSCRIBE';

        $this->request($params, $handle);
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     */
    public function unsubscribe($params, Handle $handle)
    {
        $params['method'] = 'UNSUBSCRIBE';

        $this->request($params, $handle);
    }
}
