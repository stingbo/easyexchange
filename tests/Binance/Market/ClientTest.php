<?php

namespace EasyExchange\Tests\Binance\Market;

use EasyExchange\Binance\Market\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testDepth()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/depth', [
            'symbol' => 'ETHBTC',
            'limit' => 10,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depth('ETHBTC', 10));
    }

    public function testTrades()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/trades', [
            'symbol' => 'ETHBTC',
            'limit' => 10,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->trades('ETHBTC', 10));
    }

    public function testHistoricalTrades()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('/api/v3/historicalTrades', [
            'symbol' => 'ETHBTC',
            'fromId' => 100,
            'limit' => 10,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->historicalTrades('ETHBTC', 100, 10));
    }

    public function testAggTrades()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'ETHBTC',
            'fromID' => 100,
            'startTime' => 123412432341100,
            'endTime' => 123412432341101,
            'limit' => 10,
        ];

        $client->expects()->httpGet('/api/v3/aggTrades', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->aggTrades($params));
    }

    public function testHr24()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'ETHBTC';
        $params = [
            'symbol' => $symbol,
        ];

        $client->expects()->httpGet('/api/v3/ticker/24hr', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hr24($symbol));
    }

    public function testKline()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'symbol' => 'ETHBTC',
            'interval' => 'MINUTE',
            'startTime' => 1618104403000,
            'endTime' => 1618104408000,
            'limit' => 10,
        ];

        $client->expects()->httpGet('/api/v3/klines', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->kline($params));
    }

    public function testAvgPrice()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'ETHBTC';
        $params = [
            'symbol' => $symbol,
        ];

        $client->expects()->httpGet('/api/v3/avgPrice', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->avgPrice($symbol));
    }

    public function testPrice()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'ETHBTC';
        $params = [
            'symbol' => $symbol,
        ];

        $client->expects()->httpGet('/api/v3/ticker/price', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->price($symbol));
    }

    public function testBookTicker()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'ETHBTC';
        $params = [
            'symbol' => $symbol,
        ];

        $client->expects()->httpGet('/api/v3/ticker/bookTicker', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->bookTicker($symbol));
    }
}
