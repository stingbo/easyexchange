<?php

namespace EasyExchange\Tests\Huobi\Market;

use EasyExchange\Huobi\Market\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testDepth()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'symbol' => 'ETHBTC',
            'type' => 'step0',
            'depth' => 10,
        ];
        $client->expects()->httpGet('/market/depth', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depth($params));
    }

    public function testTrades()
    {
        $client = $this->mockApiClient(Client::class);

        $symbol = 'ethusdt';
        $params = [
            'symbol' => $symbol,
        ];
        $client->expects()->httpGet('/market/trade', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->trades($symbol));
    }

    public function testHistoricalTrades()
    {
        $client = $this->mockApiClient(Client::class);

        $symbol = 'ethusdt';
        $size = 10;
        $params = [
            'symbol' => $symbol,
            'size' => $size,
        ];
        $client->expects()->httpGet('/market/history/trade', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->historicalTrades($symbol, $size));
    }

    public function testAggTrades()
    {
        $client = $this->mockApiClient(Client::class);

        $symbol = 'ethusdt';
        $params = [
            'symbol' => $symbol,
        ];
        $client->expects()->httpGet('/market/detail/merged', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->aggTrades($symbol));
    }

    public function testHr24()
    {
        $client = $this->mockApiClient(Client::class);

        $symbol = 'ethusdt';
        $params = [
            'symbol' => $symbol,
        ];
        $client->expects()->httpGet('/market/detail', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hr24($symbol));
    }

    public function testKline()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'symbol' => 'ETHBTC',
            'period' => '1day',
            'size' => 10,
        ];
        $client->expects()->httpGet('/market/history/kline', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->kline($params));
    }

    public function testTickers()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [];
        $client->expects()->httpGet('/market/tickers', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->tickers());
    }

    public function testEtp()
    {
        $client = $this->mockApiClient(Client::class);

        $symbol = 'ethusdt';
        $params = [
            'symbol' => $symbol,
        ];
        $client->expects()->httpGet('/market/etp', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->etp($symbol));
    }
}
