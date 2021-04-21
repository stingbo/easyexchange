<?php

namespace EasyExchange\Tests\Okex\Market;

use EasyExchange\Okex\Market\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testTickers()
    {
        $client = $this->mockApiClient(Client::class);
        $instType = 'SWAP';
        $uly = 'BTC-USD';
        $params = [
            'instType' => $instType,
            'uly' => $uly,
        ];

        $client->expects()->httpGet('/api/v5/market/tickers', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->tickers($instType, $uly));
    }

    public function testDepth()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v5/market/books', [
            'instId' => 'ETHBTC',
            'sz' => 10,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depth('ETHBTC', 10));
    }
}
