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
            'symbol' => 'BTCUSDT',
            'recvWindow' => 10000,
        ];

        $client->expects()->httpGet('/api/v3/openOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders('BTCUSDT', 10000));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpDelete('/api/v3/order', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($params));
    }

    public function testOrderTest()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'BTCUSDT',
            'side' => 'BUY',
            'type' => 'MARKET',
            'quantity' => 0.1,
            'price' => 2000,
        ];

        $client->expects()->httpPost('/api/v3/order/test', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->orderTest($params));
    }

    public function testCancelOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'ETHBTC';
        $recvWindow = 50000;
        $params = [
            'symbol' => $symbol,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpDelete('api/v3/openOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrders($symbol, $recvWindow));
    }

    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => 10000,
        ];

        $client->expects()->httpGet('/api/v3/order', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->get($params));
    }

    public function testAllOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => 10000,
        ];

        $client->expects()->httpGet('/api/v3/allOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->allOrders($params));
    }

    public function testMyTrades()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => 50000,
        ];

        $client->expects()->httpGet('/api/v3/myTrades', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->myTrades($params));
    }

    public function testOco()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'BTCUSDT',
            'side' => 'BUY',
            'quantity' => 0.01,
            'price' => 2000,
        ];

        $client->expects()->httpPost('/api/v3/order/oco', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->oco($params));
    }

    public function testCancelOcoOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'BTCUSDT',
        ];

        $client->expects()->httpDelete('/api/v3/orderList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOcoOrder($params));
    }

    public function testGetOcoOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'orderListId' => 27,
        ];

        $client->expects()->httpGet('/api/v3/orderList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getOcoOrder($params));
    }

    public function testAllOrderList()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'fromId' => 27,
            'startTime' => 1565245913483,
            'endTime' => 1565245923483,
            'limit' => 10,
        ];

        $client->expects()->httpGet('/api/v3/allOrderList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->allOrderList($params));
    }

    public function testOpenOrderList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 10000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/api/v3/openOrderList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrderList($recvWindow));
    }
}
