<?php

namespace EasyExchange\Tests\Huobi\User;

use EasyExchange\Huobi\User\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testAccounts()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/v1/account/accounts', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->accounts($params));
    }

    public function testBalance()
    {
        $client = $this->mockApiClient(Client::class);
        $account_id = 'a001';
        $params = [];

        $client->expects()->httpGet(sprintf('/v1/account/accounts/%s/balance', $account_id), $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->balance($account_id));
    }

    public function testAssetValuation()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [];

        $client->expects()->httpGet('/v2/account/asset-valuation', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->assetValuation($params));
    }

    public function testTransfer()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'from-user' => '19211',
            'from-account-type' => 'spot',
            'from-account' => 'a0001',
            'to-user' => '19221',
            'to-account-type' => 'spot',
            'to-account' => 'a0002',
            'symbol' => 'ethusdt',
            'currency' => 'btc',
            'amount' => '1.0',
        ];
        $client->expects()->httpPostJson('/v1/account/transfer', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->transfer($params));
    }

    public function testHistory()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'accountType' => 'spot',
            'valuationCurrency' => 'BTC',
        ];

        $client->expects()->httpGet('/v2/account/asset-valuation', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->assetValuation($params));
    }

    public function testLedger()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'accountId' => 'a001',
            'currency' => 'btc',
            'transactTypes' => 'transfer',
            'limit' => 10,
        ];

        $client->expects()->httpGet('/v2/account/ledger', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->ledger($params));
    }

    public function testFuturesTransfer()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'currency' => 'btc',
            'amount' => '1.0',
            'type' => 'pro-to-futures',
        ];
        $client->expects()->httpPostJson('/v1/futures/transfer', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->futuresTransfer($params));
    }

    public function testPoint()
    {
        $client = $this->mockApiClient(Client::class);
        $subUid = 'a0001';
        $params = [
            'subUid' => $subUid,
        ];

        $client->expects()->httpGet('/v2/point/account', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->point($subUid));
    }

    public function testPointTransfer()
    {
        $client = $this->mockApiClient(Client::class);

        $params = [
            'fromUid' => 192321,
            'toUid' => 193321,
            'groupId' => 11221,
            'amount' => '1.0',
        ];
        $client->expects()->httpPostJson('/v2/point/transfer', $params, [], 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->pointTransfer($params));
    }
}
