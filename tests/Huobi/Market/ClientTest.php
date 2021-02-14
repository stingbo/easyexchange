<?php

namespace EasyExchange\Tests\Huobi\Market;

use EasyExchange\Huobi\Market\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testDepth()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/market/depth', [
            'symbol' => 'ETHBTC',
            'type' => 'step0',
            'depth' => 10,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depth('ETHBTC', 'step0', 10));
    }
}
