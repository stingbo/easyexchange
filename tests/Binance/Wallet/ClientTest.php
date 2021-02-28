<?php

namespace EasyExchange\Tests\Binance\Wallet;

use EasyExchange\Binance\Wallet\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testAccount()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/account', ['recvWindow' => 123], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->account(123));
    }
}
