<?php

namespace EasyExchange\Tests\Huobi\Algo;

use EasyExchange\Huobi\Algo\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testOrder()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'accountId' => 88,
            'symbol' => 'ETHBTC',
            'orderPrice' => 11,
            'orderSide' => 'buy',
            'orderSize' => 0.1,
            'orderType' => 'market',
            'clientOrderId' => 'a0001',
            'stopPrice' => 11,
        ];
        $client->expects()->httpPostJson('/v2/algo-orders', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->order($params));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);

        $clientOrderIds = [
            'a001',
            'a002',
        ];
        $params = [
            'clientOrderIds' => $clientOrderIds,
        ];
        $client->expects()->httpPostJson('/v2/algo-orders/cancellation', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($clientOrderIds));
    }

    public function testOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'accountId' => 88,
            'symbol' => 'ETHBTC',
            'orderSide' => 'buy',
            'orderType' => 'market',
            'sort' => 'desc',
            'limit' => 20,
            'fromId' => 100,
        ];
        $client->expects()->httpGet('/v2/algo-orders/opening', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders($params));
    }

    public function testOrderHistory()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'accountId' => 88,
            'symbol' => 'ETHBTC',
            'orderSide' => 'buy',
            'orderType' => 'market',
            'orderStatus' => 'triggered',
            'sort' => 'desc',
            'limit' => 20,
            'fromId' => 100,
        ];
        $client->expects()->httpGet('/v2/algo-orders/history', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->orderHistory($params));
    }

    public function testSpecific()
    {
        $client = $this->mockApiClient(Client::class);

        $clientOrderId = 'a001';
        $params = [
            'clientOrderId' => $clientOrderId,
        ];
        $client->expects()->httpGet('/v2/algo-orders/specific', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->specific($clientOrderId));
    }
}
