<?php

namespace EasyExchange\Tests\Huobi\Margin;

use EasyExchange\Huobi\Margin\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testRepayment()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'accountId' => 1266826,
            'currency' => 'btc',
            'amount' => '0.00800334',
            'transactId' => 437,
        ];
        $client->expects()->httpPostJson('/v2/account/repayment', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->repayment($params));
    }

    public function testTransferIn()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'symbol' => 'ethusdt',
            'currency' => 'btc',
            'amount' => '1.0',
        ];
        $client->expects()->httpPostJson('/v1/dw/transfer-in/margin', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transferIn($params));
    }

    public function testTransferOut()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'symbol' => 'ethusdt',
            'currency' => 'btc',
            'amount' => '1.0',
        ];
        $client->expects()->httpPostJson('/v1/dw/transfer-out/margin', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transferOut($params));
    }

    public function testLoanInfo()
    {
        $client = $this->mockApiClient(Client::class);
        $symbols = 'btcusdt';
        $params = [
            'symbols' => $symbols,
        ];

        $client->expects()->httpGet('/v1/margin/loan-info', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->loanInfo($params));
    }

    public function testOrders()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'symbol' => 'ethusdt',
            'currency' => 'btc',
            'amount' => '1.0',
        ];
        $client->expects()->httpPostJson('/v1/margin/orders', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->orders($params));
    }

    public function testRepay()
    {
        $client = $this->mockApiClient(Client::class);

        $order_id = '1001';
        $amount = '1.0';
        $params = [
            'amount' => $amount,
        ];
        $client->expects()->httpPostJson(sprintf('/v1/margin/orders/%s/repay', $order_id), $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->repay($order_id, $amount));
    }

    public function testLoanOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $symbols = 'btcusdt';
        $params = [
            'symbols' => $symbols,
        ];

        $client->expects()->httpGet('/v1/margin/loan-orders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->loanOrders($params));
    }

    public function testBalance()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'btcusdt';
        $params = [
            'symbol' => $symbol,
        ];

        $client->expects()->httpGet('/v1/margin/accounts/balance', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->balance($symbol));
    }

    public function testCrossTransferIn()
    {
        $client = $this->mockApiClient(Client::class);

        $currency = 'eth';
        $amount = '1.0';
        $params = [
            'currency' => $currency,
            'amount' => $amount,
        ];
        $client->expects()->httpPostJson('/v1/cross-margin/transfer-in', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->crossTransferIn($currency, $amount));
    }

    public function testCrossTransferOut()
    {
        $client = $this->mockApiClient(Client::class);

        $currency = 'eth';
        $amount = '1.0';
        $params = [
            'currency' => $currency,
            'amount' => $amount,
        ];
        $client->expects()->httpPostJson('/v1/cross-margin/transfer-out', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->crossTransferOut($currency, $amount));
    }

    public function testCrossLoanInfo()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/v1/cross-margin/loan-info', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->crossLoanInfo($params));
    }

    public function testCrossOrders()
    {
        $client = $this->mockApiClient(Client::class);

        $currency = 'eth';
        $amount = '1.0';
        $params = [
            'currency' => $currency,
            'amount' => $amount,
        ];
        $client->expects()->httpPostJson('/v1/cross-margin/orders', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->crossOrders($currency, $amount));
    }

    public function testCrossRepay()
    {
        $client = $this->mockApiClient(Client::class);

        $order_id = '1001';
        $amount = '1.0';
        $params = [
            'amount' => $amount,
        ];
        $client->expects()->httpPostJson(sprintf('/v1/cross-margin/orders/%s/repay', $order_id), $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->crossRepay($order_id, $amount));
    }

    public function testCrossLoanOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'currency' => 'btc',
            'state' => 'created',
            'size' => 10,
        ];

        $client->expects()->httpGet('/v1/cross-margin/loan-orders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->crossLoanOrders($params));
    }

    public function testCrossBalance()
    {
        $client = $this->mockApiClient(Client::class);
        $sub_uid = '1001';
        $params = [
            'sub-uid' => $sub_uid,
        ];

        $client->expects()->httpGet('/v1/cross-margin/accounts/balance', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->crossBalance($sub_uid));
    }

    public function testGetRepayment()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/v2/account/repayment', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getRepayment($params));
    }
}
