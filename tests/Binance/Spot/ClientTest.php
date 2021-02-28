<?php

namespace EasyExchange\Tests\Binance\Spot;

use EasyExchange\Binance\Spot\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpPost('/api/v3/order', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->order($params));
    }

    public function testOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'btcusdt',
            'recvWindow' => 10000,
        ];

        $client->expects()->httpGet('/api/v3/openOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders('btcusdt', 10000));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpDelete('/api/v3/order', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($params));
    }
}
