<?php

namespace EasyExchange\Tests\Binance\Trade;

use EasyExchange\Binance\Trade\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpPost('/api/v3/order', $params, 'TRADE')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->order($params));
    }
}
