<?php

namespace EasyExchange\Okex\Websocket;

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
        $params['op'] = 'subscribe';

        $this->request('/ws/v5/public', $params, $handle);
    }

    /**
     * Unsubscribe to a stream.
     *
     * @param $params
     */
    public function unsubscribe($params, DataHandle $handle)
    {
        $params['op'] = 'unsubscribe';

        $this->request('/ws/v5/public', $params, $handle);
    }
}
