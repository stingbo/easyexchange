<?php

namespace EasyExchange\Okex\Market;

use EasyExchange\Kernel\BaseClient;

class Client extends BaseClient
{
    public function depth($instId, $sz = 1)
    {
        return $this->httpGet('/api/v5/market/books', compact('instId', 'sz'));
    }
}
