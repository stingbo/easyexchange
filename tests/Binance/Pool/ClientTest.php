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

        $client->expects()->httpGet('/sapi/v1/mining/pub/coinList', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->coinList($recvWindow));
    }

    public function testWorkerDetail()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'algo' => 'sha256',
            'userName' => 'test',
            'workerName' => 'bhdc1.16A10404B',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/worker/detail', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->workerDetail($params));
    }

    public function testWorkerList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'algo' => 'sha256',
            'userName' => 'test',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/worker/list', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->workerList($params));
    }

    public function testPaymentList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'algo' => 'sha256',
            'userName' => 'test',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/payment/list', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->paymentList($params));
    }

    public function testPaymentOther()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'algo' => 'sha256',
            'userName' => 'test',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/payment/other', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->paymentOther($params));
    }

    public function testHashTransferConfigDetails()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'pageIndex' => 1,
            'pageSize' => 5,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/hash-transfer/config/details', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hashTransferConfigDetails($params));
    }

    public function testHashTransferConfigDetailsList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'pageIndex' => 1,
            'pageSize' => 5,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/hash-transfer/config/details/list', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hashTransferConfigDetailsList($params));
    }

    public function testHashTransferProfitDetails()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'configId' => '168',
            'pageIndex' => 1,
            'pageSize' => 5,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/hash-transfer/profit/details', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hashTransferProfitDetails($params));
    }

    public function testHashTransferConfig()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'userName' => 'test',
            'algo' => 'sha256',
            'startDate' => 1617659086000,
            'endDate' => 1607659086000,
            'toPoolUser' => 'S19pro',
            'hashRate' => '100000000',
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
            'configId' => 168,
            'userName' => 'test',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/mining/hash-transfer/config/cancel', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->hashTransferConfigCancel($params));
    }

    public function testUserStatus()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'algo' => 'sha256',
            'userName' => 'test',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/statistics/user/status', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->userStatus($params));
    }

    public function testUserList()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'algo' => 'sha256',
            'userName' => 'test',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/mining/statistics/user/list', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->userList($params));
    }
}
