<?php

namespace EasyExchange\Tests\Huobi\C2C;

use EasyExchange\Huobi\C2C\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testOrder()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'accountId' => 88,
            'currency' => 'ETH',
            'side' => 'lend',
            'amount' => 10,
            'interestRate' => 0.1,
            'loanTerm' => 10,
        ];
        $client->expects()->httpPostJson('/v2/c2c/offer', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->order($params));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);

        $offerId = 14411;
        $params = [
            'offerId' => $offerId,
        ];
        $client->expects()->httpPostJson('/v2/c2c/cancellation', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($offerId));
    }

    public function testCancelAll()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'accountId' => 88,
            'currency' => 'ETH',
            'side' => 'lend',
        ];

        $client->expects()->httpPostJson('/v2/c2c/cancel-all', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelAll($params));
    }

    public function testGetOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'accountId' => 88,
            'currency' => 'ETH',
            'side' => 'lend',
            'offerStatus' => 'submitted,filled,partial-filled,canceled,partial-canceled',
        ];

        $client->expects()->httpGet('/v2/c2c/offers', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getOrders($params));
    }

    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $offerId = 14736;
        $params = [
            'offerId' => $offerId,
        ];

        $client->expects()->httpGet('/v2/c2c/offer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->get($offerId));
    }

    public function testTransactions()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'accountId' => 88,
            'currency' => 'usdt',
            'side' => 'lend',
            'transactStatus' => 'pending',
        ];

        $client->expects()->httpGet('/v2/c2c/transactions', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transactions($params));
    }

    public function testRepayment()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'accountId' => 88,
            'currency' => 'usdt',
            'amount' => 10,
            'offerId' => 12312,
        ];

        $client->expects()->httpPostJson('/v2/c2c/repayment', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->repayment($params));
    }

    public function testGetRepayment()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'repayId' => 2173,
            'accountId' => 88,
            'currency' => 'usdt',
        ];

        $client->expects()->httpGet('/v2/c2c/repayment', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getRepayment($params));
    }

    public function testTransfer()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'from' => 88,
            'to' => 89,
            'currency' => 'usdt',
            'amount' => 10,
        ];

        $client->expects()->httpPostJson('/v2/c2c/transfer', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transfer($params));
    }

    public function testBalance()
    {
        $client = $this->mockApiClient(Client::class);
        $accountId = 88;
        $currency = 'usdt';
        $params = [
            'accountId' => $accountId,
            'currency' => $currency,
        ];

        $client->expects()->httpGet('/v2/c2c/account', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->balance($accountId, $currency));
    }
}
