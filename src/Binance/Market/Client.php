<?php

namespace EasyExchange\Binance\Market;

use EasyExchange\Kernel\BaseClient;

class Client extends BaseClient
{
    public function exchangeInfo()
    {
        return $this->httpGet('/api/v3/exchangeInfo');
    }

    public function depth($symbol, int $limit = 100)
    {
        return $this->httpGet('/api/v3/depth', compact('symbol', 'limit'));
    }

    public function trades($symbol, int $limit = 500)
    {
        return $this->httpGet('/api/v3/trades', compact('symbol', 'limit'));
    }

    public function historicalTrades($symbol, $fromId = '', int $limit = 500)
    {
        return $this->httpGet('/api/v3/historicalTrades', compact('symbol', 'fromId', 'limit'));
    }

    public function aggTrades($symbol, $fromId = '', $startTime = '', $endTime = '', int $limit = 50)
    {
        $request = ['symbol' => $symbol];
        if ($fromId) {
            $request['fromId'] = $fromId;
        }
        if ($startTime) {
            $request['startTime'] = $startTime;
        }
        if ($endTime) {
            $request['endTime'] = $endTime;
        }
        if ($limit) {
            $request['limit'] = $limit;
        }

        return $this->httpGet('/api/v3/aggTrades', $request);
    }
}
