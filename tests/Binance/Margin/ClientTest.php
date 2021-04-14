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
    }

    public function testRepay()
    {
    }

    public function testAsset()
    {
    }

    public function testAllAssets()
    {
    }

    public function testPair()
    {
    }

    public function testAllPairs()
    {
    }

    public function testPriceIndex()
    {
    }

    public function testOrder()
    {
    }

    public function testCancelOrder()
    {
    }

    public function testCancelOrders()
    {
    }

    public function testTransferHistory()
    {
    }

    public function testLoanHistory()
    {
    }

    public function testRepayHistory()
    {
    }

    public function testInterestHistory()
    {
    }

    public function testForceLiquidationRec()
    {
    }

    public function testAccount()
    {
    }

    public function testGet()
    {
    }

    public function testOpenOrders()
    {
    }

    public function testAllOrders()
    {
    }

    public function testMyTrades()
    {
    }

    public function testMaxBorrowable()
    {
    }

    public function testMaxTransferable()
    {
    }

    public function testCreate()
    {
    }

    public function testIsolatedTransfer()
    {
    }

    public function testIsolatedTransferHistory()
    {
    }

    public function testIsolatedAccount()
    {
    }

    public function testIsolatedPair()
    {
    }

    public function testIsolatedAllPairs()
    {
    }

    public function testInterestRateHistory()
    {
    }
}
