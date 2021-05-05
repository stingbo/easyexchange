<?php

namespace EasyExchange\Gate\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use EasyExchange\Kernel\Websocket\Handle;

class Client extends BaseClient
{
    /**
     * Subscribe.
     *
     * @param $params
     */
    public function subscribe($params, Handle $handle)
    {
        $params['event'] = 'subscribe';

        $this->request($params, $handle);
    }
}
