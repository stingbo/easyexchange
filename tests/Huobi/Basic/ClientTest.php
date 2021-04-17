<?php

namespace EasyExchange\Tests\Huobi\Basic;

use EasyExchange\Huobi\Basic\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testSystemTime()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/v1/common/timestamp')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->systemTime());
    }

    public function testMarketStatus()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/v2/market-status')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->marketStatus());
    }

    public function testExchangeInfo()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/v1/common/symbols')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->exchangeInfo());
    }

    public function testSystemStatus()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('https://status.huobigroup.com/api/v2/summary.json')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->systemStatus());
    }

    public function testCurrencys()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/v1/common/currencys')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->currencys());
    }

    public function testCurrencies()
    {
        $client = $this->mockApiClient(Client::class);

        $currency = 'usdt';
        $authorizedUser = true;
        $params = [
            'currency' => $currency,
            'authorizedUser' => $authorizedUser,
        ];
        $client->expects()->httpGet('/v2/reference/currencies', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->currencies($currency, $authorizedUser));
    }

    public function testSymbols()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/v1/common/symbols')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->symbols());
    }
}
