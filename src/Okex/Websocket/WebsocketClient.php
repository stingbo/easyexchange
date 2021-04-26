<?php

namespace EasyExchange\Okex\Websocket;

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
        $params['op'] = 'subscribe';

        $this->request($params, $handle);
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     */
    public function unsubscribe($params, Handle $handle)
    {
        $params['op'] = 'unsubscribe';

        $this->request($params, $handle);
    }
}
