<?php

namespace EasyExchange\Tests\Huobi\Trade;

use EasyExchange\Huobi\Trade\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'account-id' => '100009',
            'symbol' => 'ethusdt',
            'type' => 'buy-limit',
            'amount' => '10.1',
            'price' => '100.1',
            'source' => 'api',
            'client-order-id' => 'a0001',
        ];

        $client->expects()->httpPostJson('/v1/order/orders/place', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->order($params));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $order_id = 'a000001';
        $params = [];

        $client->expects()->httpPost(sprintf('/v1/order/orders/%s/submitcancel', $order_id), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($order_id));
    }

    public function testBatchOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            [
                'account-id' => '123456',
                'price' => '7801',
                'amount' => '0.001',
                'symbol' => 'btcusdt',
                'type' => 'sell-limit',
                'client-order-id' => 'c1',
            ],
            [
                'account-id' => '123456',
                'price' => '7802',
                'amount' => '0.001',
                'symbol' => 'btcusdt',
                'type' => 'sell-limit',
                'client-order-id' => 'd2',
            ],
        ];

        $client->expects()->httpPostJson('/v1/order/batch-orders', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->batchOrders($params));
    }

    public function testCancelClientOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $client_order_id = 'a0001';
        $params = [
            'client-order-id' => $client_order_id,
        ];

        $client->expects()->httpPostJson('/v1/order/orders/submitCancelClientOrder', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelClientOrder($client_order_id));
    }

    public function testCancelAllAfter()
    {
        $client = $this->mockApiClient(Client::class);
        $timeout = 10;
        $params = [
            'timeout' => $timeout,
        ];

        $client->expects()->httpPostJson('/v2/algo-orders/cancel-all-after', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelAllAfter($timeout));
    }

    public function testOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'account-id' => '100009',
            'symbol' => 'ethusdt',
            'side' => 'buy',
        ];

        $client->expects()->httpGet('/v1/order/openOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders($params));
    }

    public function testBatchCancelOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'account-id' => '100009',
            'symbol' => 'ethusdt',
            'side' => 'buy',
        ];

        $client->expects()->httpPostJson('/v1/order/orders/batchCancelOpenOrders', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->batchCancelOpenOrders($params));
    }

    public function testBatchCancel()
    {
        $client = $this->mockApiClient(Client::class);
        $order_ids = [];
        $client_order_ids = [
            '5983466', '5722939', '5721027', '5719487',
        ];
        $params = [
            'order_ids' => $order_ids,
            'client_order_ids' => $client_order_ids,
        ];

        $client->expects()->httpPostJson('/v1/order/orders/batchcancel', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->batchCancel($order_ids, $client_order_ids));
    }

    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $order_id = 'a000001';
        $params = [];

        $client->expects()->httpGet(sprintf('/v1/order/orders/%s', $order_id), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->get($order_id));
    }

    public function testGetClientOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $clientOrderId = 'a000001';
        $params = [
            'clientOrderId' => $clientOrderId,
        ];

        $client->expects()->httpGet('/v1/order/orders/getClientOrder', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getClientOrder($clientOrderId));
    }

    public function testMatchResult()
    {
        $client = $this->mockApiClient(Client::class);
        $order_id = 'a000001';
        $params = [];

        $client->expects()->httpGet(sprintf('/v1/order/orders/%s/matchresults', $order_id), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->matchResult($order_id));
    }

    public function testGetOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'account-id' => '100009',
            'amount' => '10.1',
            'price' => '100.1',
            'source' => 'api',
            'symbol' => 'ethusdt',
            'type' => 'buy-limit',
        ];

        $client->expects()->httpGet('/v1/order/orders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getOrders($params));
    }

    public function testHr48History()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'btcusdt',
            'start-time' => '1556417645419',
            'end-time' => '1556533539282',
            'direct' => 'prev',
            'size' => '10',
        ];

        $client->expects()->httpGet('/v1/order/history', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hr48History($params));
    }

    public function testMatchResults()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'btcusdt',
            'start-time' => '1556417645419',
            'end-time' => '1556533539282',
            'direct' => 'prev',
            'size' => '10',
        ];

        $client->expects()->httpGet('/v1/order/matchresults', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->matchresults($params));
    }

    public function testTransactFeeRate()
    {
        $client = $this->mockApiClient(Client::class);
        $symbols = 'btcusdt,ethusdt,ltcusdt';
        $params = [
            'symbols' => $symbols,
        ];

        $client->expects()->httpGet('/v2/reference/transact-fee-rate', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transactFeeRate($symbols));
    }
}
