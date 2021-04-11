<?php

namespace EasyExchange\Tests\Binance\Wallet;

use EasyExchange\Binance\Wallet\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testAccount(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/api/v3/account', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->account($recvWindow));
    }

    public function testGetAll(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/capital/config/getall', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getAll($recvWindow));
    }

    public function testAccountSnapshot(): void
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

    public function testDisableFastWithdrawSwitch(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/account/disableFastWithdrawSwitch', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->disableFastWithdrawSwitch($recvWindow));
    }

    public function testEnableFastWithdrawSwitch(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/account/enableFastWithdrawSwitch', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->enableFastWithdrawSwitch($recvWindow));
    }

    public function testWithdrawApply(): void
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

    public function testWithdraw(): void
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

    public function testCapitalDepositHistory(): void
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

    public function testDepositHistory(): void
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

    public function testCapitalWithdrawHistory(): void
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

    public function testWithdrawHistory(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'status' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/withdrawHistory.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->withdrawHistory($params));
    }

    public function testCapitalDepositAddress(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'status' => true,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/capital/deposit/address', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->capitalDepositAddress($params));
    }

    public function testDepositAddress(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'status' => true,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/depositAddress.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->depositAddress($params));
    }

    public function testAccountStatus(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/accountStatus.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->accountStatus($recvWindow));
    }

    public function testApiTradingStatus(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/apiTradingStatus.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->apiTradingStatus($recvWindow));
    }

    public function testUserAssetDribbletLog(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/userAssetDribbletLog.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->userAssetDribbletLog($recvWindow));
    }

    public function testAssetDribblet(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'startTime' => 1565245913483,
            'endTime' => 1565245923483,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/asset/dribblet', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->assetDribblet($params));
    }

    public function testAssetDust(): void
    {
        $client = $this->mockApiClient(Client::class);
        $asset = [
            'BTC',
            'USDT',
        ];
        $recvWindow = 50000;
        $params = [
            'asset' => $asset,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/asset/dust', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->assetDust($asset, $recvWindow));
    }

    public function testAssetDividend(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'startTime' => 1565245913483,
            'endTime' => 1565245923483,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/asset/assetDividend', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->assetDividend($params));
    }

    public function testAssetDetail(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/assetDetail.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->assetDetail($recvWindow));
    }

    public function testTradeFee(): void
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'BNBBTC';
        $recvWindow = 50000;
        $params = [
            'symbol' => $symbol,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/wapi/v3/tradeFee.html', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->tradeFee($symbol, $recvWindow));
    }

    public function testAssetTradeFee(): void
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'BNBBTC';
        $recvWindow = 50000;
        $params = [
            'symbol' => $symbol,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/asset/tradeFee', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->assetTradeFee($symbol, $recvWindow));
    }

    public function testTransfer(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'type' => 'MAIN_C2C',
            'asset' => 'BTC',
            'amount' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/asset/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transfer($params));
    }

    public function testTransferHistory(): void
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'type' => 'MAIN_C2C',
            'startTime' => 1565245913483,
            'endTime' => 1565245923483,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/asset/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transferHistory($params));
    }
}
