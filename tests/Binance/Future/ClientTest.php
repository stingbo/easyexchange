<?php

namespace EasyExchange\Tests\Binance\Future;

use EasyExchange\Binance\Future\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testTransfer()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'USDT',
            'amount' => 10,
            'type' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/futures/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transfer($params));
    }

    public function testTransferHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'USDT',
            'startTime' => 123412432341100,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transferHistory($params));
    }

    public function testBorrow()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'USDT',
            'amount' => 10,
            'collateralCoin' => 'BUSD',
            'collateralAmount' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/futures/loan/borrow', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->borrow($params));
    }

    public function testBorrowHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'USDT',
            'startTime' => 123412432341100,
            'endTime' => 123412432341101,
            'limit' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/borrow/history', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->borrowHistory($params));
    }

    public function testRepay()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'USDT',
            'amount' => 10,
            'collateralCoin' => 'BUSD',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/futures/loan/repay', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->repay($params));
    }

    public function testRepayHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'USDT',
            'startTime' => 123412432341100,
            'endTime' => 123412432341101,
            'limit' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/repay/history', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->repayHistory($params));
    }

    public function testWallet()
    {
        $client = $this->mockApiClient(Client::class);
        $version = 'v1';
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet(sprintf('/sapi/%s/futures/loan/wallet', $version), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->wallet($version, $recvWindow));
    }

    public function testConfigs()
    {
        $client = $this->mockApiClient(Client::class);
        $version = 'v1';
        $recvWindow = 50000;
        $params = [
            'collateralCoin' => 'BUSD', // v1 & v2
            'loanCoin' => 'BTC', // v2
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet(sprintf('/sapi/%s/futures/loan/configs', $version), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->configs($params, $version));
    }

    public function testCalcAdjustLevel()
    {
        $client = $this->mockApiClient(Client::class);
        $version = 'v1';
        $recvWindow = 50000;
        $params = [
            'loanCoin' => 'BTC', // v2
            'collateralCoin' => 'BUSD', // v1 & v2
            'amount' => '0.89736451', // v1 & v2
            'direction' => 'ADDITIONAL', // v1 & v2
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet(sprintf('/sapi/%s/futures/loan/calcAdjustLevel', $version), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->calcAdjustLevel($params, $version));
    }

    public function testCalcMaxAdjustAmount()
    {
        $client = $this->mockApiClient(Client::class);
        $version = 'v1';
        $recvWindow = 50000;
        $params = [
            'loanCoin' => 'BTC', // v2
            'collateralCoin' => 'BUSD', // v1 & v2
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet(sprintf('/sapi/%s/futures/loan/calcMaxAdjustAmount', $version), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->calcMaxAdjustAmount($params, $version));
    }

    public function testAdjustCollateral()
    {
        $client = $this->mockApiClient(Client::class);
        $version = 'v1';
        $recvWindow = 50000;
        $params = [
            'loanCoin' => 'BTC', // v2
            'collateralCoin' => 'BUSD', // v1 & v2
            'amount' => '0.89736451', // v1 & v2
            'direction' => 'ADDITIONAL', // v1 & v2
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost(sprintf('/sapi/%s/futures/loan/adjustCollateral', $version), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->adjustCollateral($params, $version));
    }

    public function testAdjustCollateralHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $version = 'v1';
        $recvWindow = 50000;
        $params = [
            'loanCoin' => 'BTC',
            'collateralCoin' => 'BUSD',
            'startTime' => 123412432341100,
            'endTime' => 123412432341101,
            'limit' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/adjustCollateral/history', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->adjustCollateralHistory($params, $version));
    }

    public function testLiquidationHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'loanCoin' => 'BTC',
            'collateralCoin' => 'BUSD',
            'startTime' => 123412432341100,
            'endTime' => 123412432341101,
            'limit' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/liquidationHistory', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->liquidationHistory($params));
    }

    public function testCollateralRepayLimit()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'USDT',
            'collateralCoin' => 'BTC',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/collateralRepayLimit', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->collateralRepayLimit($params));
    }

    public function testGetCollateralRepay()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'coin' => 'USDT',
            'collateralCoin' => 'BTC',
            'amount' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/collateralRepay', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getCollateralRepay($params));
    }

    public function testCollateralRepay()
    {
        $client = $this->mockApiClient(Client::class);
        $quoteId = '3eece81ca2734042b2f538ea0d9cbdd3';
        $recvWindow = 50000;
        $params = [
            'quoteId' => $quoteId,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/futures/loan/collateralRepay', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->collateralRepay($quoteId, $recvWindow));
    }

    public function testCollateralRepayResult()
    {
        $client = $this->mockApiClient(Client::class);
        $quoteId = '3eece81ca2734042b2f538ea0d9cbdd3';
        $recvWindow = 50000;
        $params = [
            'quoteId' => $quoteId,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/collateralRepayResult', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->collateralRepayResult($quoteId, $recvWindow));
    }

    public function testInterestHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'collateralCoin' => 'BUSD',
            'startTime' => 123412432341100,
            'endTime' => 123412432341101,
            'current' => 5,
            'limit' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/futures/loan/interestHistory', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->interestHistory($params));
    }
}
