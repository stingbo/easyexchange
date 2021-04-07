<?php

namespace EasyExchange\Binance\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\DataHandle;

class Client extends BaseClient
{
    /**
     * Subscribe to a stream.
     *
     * @param $params
     */
    public function subscribe($params, DataHandle $handle)
    {
        $params['method'] = 'SUBSCRIBE';

        $this->request('/ws', $params, $handle);
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     */
    public function unsubscribe($params, DataHandle $handle)
    {
        $params['method'] = 'UNSUBSCRIBE';

        $this->request('/ws', $params, $handle);
    }
}
