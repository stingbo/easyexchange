<?php

namespace EasyExchange\Huobi\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\DataHandle;

class Client extends BaseClient
{
    /**
     * Subscribe to Topic.
     *
     * @param $params
     */
    public function subscribe($params, DataHandle $handle)
    {
        $this->request('/ws', $params, $handle);
    }
}
