<?php

namespace EasyExchange\Gate\Websocket;

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
        $params['event'] = 'subscribe';

        $this->request('/ws/v4/', $params, $handle);
    }
}
