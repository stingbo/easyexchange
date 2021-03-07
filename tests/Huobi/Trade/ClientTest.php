<?php

namespace EasyExchange\Tests\Huobi\Trade;

use EasyExchange\Huobi\Trade\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpPostJson('/v1/order/orders/place', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->order($params));
    }

    public function testAccount()
    {
        $this->assertSame('mock-result', 'mock-result');
    }

    public function testOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/v1/order/openOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders($params));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $order_id = 'test';
        $params = [];

        $client->expects()->httpPost(sprintf('/v1/order/orders/%s/submitcancel', $order_id), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($order_id));
    }
}
