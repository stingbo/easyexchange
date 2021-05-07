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
}