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

    public function testAccount()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/account', ['timestamp' => 122, 'recvWindow' => 123], 'TRADE')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->account(122, 123));
    }

    public function testOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/api/v3/openOrders', $params, 'TRADE')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders($params));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpDelete('/api/v3/order', $params, 'TRADE')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($params));
    }
}
