<?php

namespace EasyExchange\Tests\Binance\Market;

use EasyExchange\Binance\Market\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testDepth()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/depth', [
            'symbol' => 'ETHBTC',
            'limit' => 10,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depth('ETHBTC', 10));
    }
}
