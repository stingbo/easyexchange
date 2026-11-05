<?php

namespace EasyExchange\Tests\Binance;

use EasyExchange\Factory;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class RequestAuthenticationTest extends TestCase
{
    /**
     * @dataProvider requestOrders
     */
    public function testAuthenticationFollowsEachRequest(string $module, array $calls): void
    {
        $app = Factory::binance([
            'base_uri' => 'https://binance.example',
            'app_key' => 'test-key',
            'secret' => 'test-secret',
        ]);
        $handler = new MockHandler([new Response(200, [], '{}'), new Response(200, [], '{}')]);
        $app->rebind('guzzle_handler', $handler);
        $app->rebind('logger', new NullLogger());
        $client = $app->$module;

        foreach ($calls as [$method, $args, $path, $hasKey, $isSigned]) {
            $client->$method(...$args);
            $request = $handler->getLastRequest();
            $this->assertSame($path, $request->getUri()->getPath());
            $this->assertSame($hasKey ? 'test-key' : '', $request->getHeaderLine('X-MBX-APIKEY'));

            parse_str($request->getUri()->getQuery(), $query);
            if ($isSigned) {
                $this->assertMatchesRegularExpression('/^\d+$/', $query['timestamp'] ?? '');
                $signature = $query['signature'] ?? '';
                unset($query['signature']);
                $payload = http_build_query($query).(string) $request->getBody();
                $this->assertSame(hash_hmac('sha256', $payload, 'test-secret'), $signature);
            } else {
                $this->assertArrayNotHasKey('timestamp', $query);
                $this->assertArrayNotHasKey('signature', $query);
            }
        }
    }

    public static function requestOrders(): array
    {
        $public = ['httpGet', ['/api/v3/ping'], '/api/v3/ping', false, false];
        $testOrder = ['orderTest', [['symbol' => 'BTCUSDT']], '/api/v3/order/test', true, true];
        $asset = ['asset', ['BTC'], '/sapi/v1/margin/asset', true, false];
        $account = ['account', [], '/sapi/v1/margin/account', true, true];

        return [
            'spot public then signed' => ['spot', [$public, $testOrder]],
            'spot signed then public' => ['spot', [$testOrder, $public]],
            'margin key then signed' => ['margin', [$asset, $account]],
            'margin signed then key' => ['margin', [$account, $asset]],
        ];
    }
}
