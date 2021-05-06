<?php

namespace EasyExchange\Coinbase\Socket;

use EasyExchange\Kernel\Socket\BaseClient;
use EasyExchange\Kernel\Socket\Handle;

class Client extends BaseClient
{
    /**
     * Subscribe.
     *
     * @param $params
     */
    public function subscribe($params, Handle $handle)
    {
        $params['type'] = 'subscribe';

        $this->request($params, $handle);
    }
}
