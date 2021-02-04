<?php

namespace EasyExchange\Binance\Market;

use EasyExchange\Kernel\BaseClient;

class Client extends BaseClient
{
    public function depth($symbol, int $limit = 100)
    {
        return $this->httpGet('/api/v3/depth', compact('symbol', 'limit'));
    }
}
