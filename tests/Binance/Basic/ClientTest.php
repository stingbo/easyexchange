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

    public function testSystemTime()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/time')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->systemTime());
    }

    public function testExchangeInfo()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/exchangeInfo')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->exchangeInfo());
    }

    public function testSystemStatus()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/wapi/v3/systemStatus.html')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->systemStatus());
    }
}
