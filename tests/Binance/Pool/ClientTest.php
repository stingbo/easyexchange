<?php

namespace EasyExchange\Tests\Binance\Pool;

use EasyExchange\Binance\Pool\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testAlgoList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testCoinList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testWorkerDetail()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testWorkerList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testPaymentList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testPaymentOther()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testHashTransferConfigDetails()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testHashTransferConfigDetailsList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testHashTransferProfitDetails()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testHashTransferConfig()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'amount' => 10,
            'type' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/mining/hash-transfer/config', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hashTransferConfig($params));
    }

    public function testHashTransferConfigCancel()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'amount' => 10,
            'type' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/mining/hash-transfer/config', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hashTransferConfig($params));
    }

    public function testUserStatus()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }

    public function testUserList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/pub/algoList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->algoList($recvWindow));
    }
}
