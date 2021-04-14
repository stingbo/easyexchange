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
    }

    public function testTorrow()
    {
    }

    public function testTorrowHistory()
    {
    }

    public function testTepay()
    {
    }

    public function testTepayHistory()
    {
    }

    public function testTallet()
    {
    }

    public function testTonfigs()
    {
    }

    public function testTalcAdjustLevel()
    {
    }

    public function testTalcMaxAdjustAmount()
    {
    }

    public function testTdjustCollateral()
    {
    }

    public function testTdjustCollateralHistory()
    {
    }

    public function testTiquidationHistory()
    {
    }

    public function testTollateralRepayLimit()
    {
    }

    public function testTetCollateralRepay()
    {
    }

    public function testTollateralRepay()
    {
    }

    public function testTollateralRepayResult()
    {
    }

    public function testTnterestHistory()
    {
    }
}
