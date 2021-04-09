<?php

namespace EasyExchange\Coinbase\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\DataHandle;

class Client extends BaseClient
{
    /**
     * Subscribe.
     *
     * @param $params
     */
    public function subscribe($params, DataHandle $handle)
    {
        $params['type'] = 'subscribe';

        $this->request('', $params, $handle);
    }
}
