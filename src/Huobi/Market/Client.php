<?php

namespace EasyExchange\Huobi\Market;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    public function depth($symbol, $type = 'step0', int $depth = 20)
    {
        return $this->httpGet('/market/depth', compact('symbol', 'type', 'depth'));
    }

    public function trades($symbol)
    {
        return $this->httpGet('/market/trade', compact('symbol'));
    }

    public function historicalTrades($symbol, int $size = 10)
    {
        return $this->httpGet('/market/history/trade', compact('symbol', 'size'));
    }
}
