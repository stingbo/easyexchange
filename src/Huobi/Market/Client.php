<?php

namespace EasyExchange\Huobi\Market;

use EasyExchange\Kernel\BaseClient;

class Client extends BaseClient
{
    public function depth($symbol, $type = 'step0', int $depth = 20)
    {
        return $this->httpGet('/market/depth', compact('symbol', 'type', 'depth'));
    }
}
