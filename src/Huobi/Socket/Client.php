<?php

namespace EasyExchange\Huobi\Socket;

use EasyExchange\Kernel\Socket\BaseClient;
use EasyExchange\Kernel\Socket\Handle;

class Client extends BaseClient
{
    /**
     * Subscribe to Topic.
     *
     * @param $params
     */
    public function subscribe($params, Handle $handle)
    {
        $this->request($params, $handle);
    }

    /**
     * Unsubscribe.
     *
     * @param $params
     */
    public function unsubscribe($params, Handle $handle)
    {
        $this->request($params, $handle);
    }
}
