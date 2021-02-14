<?php

namespace EasyExchange\Tests\Huobi\Trade;

use EasyExchange\Huobi\Trade\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testOrder()
    {
        $this->assertSame('mock-result', 'mock-result');
    }

    public function testAccount()
    {
        $this->assertSame('mock-result', 'mock-result');
    }

    public function testOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/v1/order/openOrders', $params, 'TRADE')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders($params));
    }
}
