<?php

namespace EasyExchange\Tests\Binance\Margin;

use EasyExchange\Binance\Margin\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testTransfer()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'amount' => 10,
            'type' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/margin/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transfer($params));
    }

    public function testLoan()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'amount' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/margin/loan', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->loan($params));
    }

    public function testRepay()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'amount' => 10,
            'type' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/margin/repay', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->repay($params));
    }

    public function testAsset()
    {
        $client = $this->mockApiClient(Client::class);
        $asset = 'BTC';
        $params = [
            'asset' => $asset,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/asset', $params, 'APIKEY')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->asset($asset));
    }

    public function testAllAssets()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/sapi/v1/margin/allAssets', $params, 'APIKEY')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->allAssets());
    }

    public function testPair()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'BTCUSDT';
        $params = [
            'symbol' => $symbol,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/pair', $params, 'APIKEY')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->pair($symbol));
    }

    public function testAllPairs()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/sapi/v1/margin/allPairs', $params, 'APIKEY')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->allPairs());
    }

    public function testPriceIndex()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'BTCUSDT';
        $params = [
            'symbol' => $symbol,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/priceIndex', $params, 'APIKEY')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->priceIndex($symbol));
    }

    public function testOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $symbol = 'BTCUSDT';
        $params = [
            'symbol' => $symbol,
            'side' => 'BUY',
            'type' => 'MARKET',
            'price' => 10000,
            'quantity' => 0.1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/margin/order', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->order($params));
    }

    public function testCancelOrder()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $symbol = 'BTCUSDT';
        $params = [
            'symbol' => $symbol,
            'orderId' => 28,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpDelete('/sapi/v1/margin/order', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrder($params));
    }

    public function testCancelOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $symbol = 'BTCUSDT';
        $params = [
            'symbol' => $symbol,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpDelete('/sapi/v1/margin/openOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->cancelOrders($params));
    }

    public function testTransferHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'size' => 10,
            'type' => 'ROLL_IN',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transferHistory($params));
    }

    public function testLoanHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'amount' => 10,
            'type' => 1,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/loan', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->loanHistory($params));
    }

    public function testRepayHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/repay', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->repayHistory($params));
    }

    public function testInterestHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/interestHistory', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->interestHistory($params));
    }

    public function testForceLiquidationRec()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/forceLiquidationRec', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->forceLiquidationRec($params));
    }

    public function testAccount()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/account', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->account($recvWindow));
    }

    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/order', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->get($params));
    }

    public function testOpenOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/openOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->openOrders($params));
    }

    public function testAllOrders()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/allOrders', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->allOrders($params));
    }

    public function testMyTrades()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/myTrades', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->myTrades($params));
    }

    public function testMaxBorrowable()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/maxBorrowable', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->maxBorrowable($params));
    }

    public function testMaxTransferable()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/maxTransferable', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->maxTransferable($params));
    }

    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'base' => 'BTCUSDT',
            'quote' => 'BTCUSDT',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/margin/isolated/create', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->create($params));
    }

    public function testIsolatedTransfer()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'symbol' => 'BTCUSDT',
            'transFrom' => 'SPOT',
            'transTo' => 'ISOLATED_MARGIN',
            'amount' => 10,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/margin/isolated/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->isolatedTransfer($params));
    }

    public function testIsolatedTransferHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'symbol' => 'BTCUSDT',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/isolated/transfer', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->isolatedTransferHistory($params));
    }

    public function testIsolatedAccount()
    {
        $client = $this->mockApiClient(Client::class);
        $symbols = 'BTCUSDT,BNBUSDT,ADAUSDT';
        $recvWindow = 50000;
        $params = [
            'symbols' => $symbols,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/isolated/account', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->isolatedAccount($symbols, $recvWindow));
    }

    public function testIsolatedPair()
    {
        $client = $this->mockApiClient(Client::class);
        $symbol = 'BTCUSDT,BNBUSDT,ADAUSDT';
        $recvWindow = 50000;
        $params = [
            'symbol' => $symbol,
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/isolated/pair', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->isolatedPair($symbol, $recvWindow));
    }

    public function testIsolatedAllPairs()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/isolated/allPairs', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->isolatedAllPairs($recvWindow));
    }

    public function testInterestRateHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'asset' => 'BTC',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/margin/interestRateHistory', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->interestRateHistory($params));
    }
}
