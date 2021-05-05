<?php

namespace EasyExchange\Tests\Binance\User;

use EasyExchange\Binance\User\Client;
use EasyExchange\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testGetBnbBurnStatus()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpGet('/sapi/v1/bnbBurn', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getBnbBurnStatus($recvWindow));
    }

    public function testBnbBurn()
    {
        $client = $this->mockApiClient(Client::class);
        $recvWindow = 50000;
        $params = [
            'spotBNBBurn' => 'true',
            'interestBNBBurn' => 'true',
            'recvWindow' => $recvWindow,
        ];

        $client->expects()->httpPost('/sapi/v1/bnbBurn', $params, 'SIGN')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->bnbBurn($params));
    }
}
