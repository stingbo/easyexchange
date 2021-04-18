<?php

namespace EasyExchange\Tests\Huobi\Wallet;

use EasyExchange\Huobi\Wallet\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testDepositAddress()
    {
        $client = $this->mockApiClient(Client::class);
        $currency = 'btc';
        $params = [
            'currency' => $currency,
        ];

        $client->expects()->httpGet('/v2/account/deposit/address', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depositAddress($currency));
    }

    public function testWithdrawQuota()
    {
        $client = $this->mockApiClient(Client::class);
        $currency = 'btc';
        $params = [
            'currency' => $currency,
        ];

        $client->expects()->httpGet('/v2/account/withdraw/quota', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->withdrawQuota($currency));
    }

    public function testWithdrawAddress()
    {
        $client = $this->mockApiClient(Client::class);
        $currency = 'btc';
        $params = [
            'currency' => $currency,
        ];

        $client->expects()->httpGet('/v2/account/withdraw/address', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->withdrawAddress($params));
    }

    public function testWithdraw()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'address' => '0xde709f2102306220921060314715629080e2fb78',
            'currency' => 'btc',
            'amount' => '0.05',
            'fee' => '0.01',
        ];
        $client->expects()->httpPostJson('/v1/dw/withdraw/api/create', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->withdraw($params));
    }

    public function testCancelWithdraw()
    {
        $client = $this->mockApiClient(Client::class);

        $withdraw_id = '1';
        $params = [];
        $client->expects()->httpPostJson(sprintf('/v1/dw/withdraw-virtual/%s/cancel', $withdraw_id), $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelWithdraw($withdraw_id));
    }

    public function testDepositHistory()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'currency' => 'btc',
            'type' => 'deposit',
            'size' => 10,
        ];
        $client->expects()->httpGet('/v1/query/deposit-withdraw', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depositHistory($params));
    }
}
