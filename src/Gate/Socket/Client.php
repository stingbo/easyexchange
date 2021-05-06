<?php

namespace EasyExchange\Gate\Socket;

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
        $params['event'] = 'subscribe';

        $this->request($params, $handle);
    }
}
