<?php

namespace EasyExchange\Tests\Binance\Wallet;

use EasyExchange\Binance\Wallet\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testAccount()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/api/v3/account', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->account($recvWindow));
    }

    public function testGetAll()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/capital/config/getall', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getAll($recvWindow));
    }

    public function testAccountSnapshot()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'type' => 'SPOT',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/accountSnapshot', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->accountSnapshot($params));
    }

    public function testDisableFastWithdrawSwitch()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/account/disableFastWithdrawSwitch', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->disableFastWithdrawSwitch($recvWindow));
    }

    public function testEnableFastWithdrawSwitch()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/account/enableFastWithdrawSwitch', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->enableFastWithdrawSwitch($recvWindow));
    }

    public function testWithdrawApply()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'BTC',
            'amount' => 1,
            'address' => 'xxxxx',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/capital/withdraw/apply', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->withdrawApply($params));
    }

    public function testWithdraw()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'amount' => 1,
            'address' => 'xxxxx',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/wapi/v3/withdraw.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->withdraw($params));
    }

    public function testCapitalDepositHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'BTC',
            'status' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/capital/deposit/hisrec', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->capitalDepositHistory($params));
    }

    public function testDepositHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'status' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/depositHistory.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depositHistory($params));
    }

    public function testCapitalWithdrawHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'BTC',
            'status' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/capital/withdraw/history', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->capitalWithdrawHistory($params));
    }

    public function testWithdrawHistory()
    {
    }

    public function testCapitalDepositAddress()
    {
    }

    public function testDepositAddress()
    {
    }

    public function testAccountStatus()
    {
    }

    public function testApiTradingStatus()
    {
    }

    public function testUserAssetDribbletLog()
    {
    }

    public function testAssetDust()
    {
    }

    public function testAssetDividend()
    {
    }

    public function testAssetDetail()
    {
    }

    public function testTradeFee()
    {
    }

    public function testTransfer()
    {
    }

    public function testTransferHistory()
    {
    }
}
