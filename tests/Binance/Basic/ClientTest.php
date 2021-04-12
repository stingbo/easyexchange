<?php

namespace EasyExchange\Tests\Binance\Basic;

use EasyExchange\Binance\Basic\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testPing()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/ping')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->ping());
    }
}
