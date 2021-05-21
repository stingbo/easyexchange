<?php

namespace EasyExchange\Tests\Okex\Wallet;

use EasyExchange\Okex\Wallet\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testDepositAddress()
    {
        $client = $this->mockApiClient(Client::class);
        $ccy = 'BTC';
        $params = [
            'ccy' => $ccy,
        ];

        $client->expects()->httpGet('/api/v5/asset/deposit-address', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depositAddress($ccy));
    }

    public function testBalance()
    {
        $client = $this->mockApiClient(Client::class);
        $ccy = 'BTC,ETH';
        $params = [
            'ccy' => $ccy,
        ];

        $client->expects()->httpGet('/api/v5/asset/balances', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->balance($ccy));
    }

    public function testTransfer()
    {
        $client = $this->mockApiClient(Client::class);
        $ccy = 'USDT';
        $params = [
            'ccy' => $ccy,
            'amt' => 1.5,
            'from' => 6,
            'to' => 18,
        ];

        $client->expects()->httpPostJson('/api/v5/asset/transfer', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transfer($params));
    }

    public function testWithdrawal()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'amt' => '1',
            'fee' => '0.0005',
            'pwd' => '123456',
            'dest' => '4',
            'ccy' => 'BTC',
            'toAddr' => '17DKe3kkkkiiiiTvAKKi2vMPbm1Bz3CMKw',
        ];

        $client->expects()->httpPostJson('/api/v5/asset/withdrawal', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->withdrawal($params));
    }

    public function testDepositHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'ccy' => 'BTC',
        ];

        $client->expects()->httpGet('/api/v5/asset/deposit-history', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depositHistory($params));
    }
}
