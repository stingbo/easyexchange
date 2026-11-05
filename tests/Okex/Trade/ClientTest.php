<?php

namespace EasyExchange\Tests\Okex\Trade;

use EasyExchange\Factory;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ClientTest extends TestCase
{
    /**
     * @dataProvider orderBodies
     */
    public function testOrderSignsTheSentJson(array $params, string $expectedBody): void
    {
        $app = Factory::okex([
            'base_uri' => 'https://okx.example',
            'app_key' => 'test-key',
            'secret' => 'test-secret',
            'passphrase' => 'test-passphrase',
            'x-simulated-trading' => '0',
        ]);
        $handler = new MockHandler([new Response(200, [], '{}')]);
        $app->rebind('guzzle_handler', $handler);
        $app->rebind('logger', new NullLogger());

        $timezone = date_default_timezone_get();
        try {
            $app->trade->order($params);
        } finally {
            date_default_timezone_set($timezone);
        }

        $request = $handler->getLastRequest();
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('/api/v5/trade/order', $request->getRequestTarget());
        $this->assertSame($expectedBody, (string) $request->getBody());

        $timestamp = $request->getHeaderLine('OK-ACCESS-TIMESTAMP');
        $this->assertNotSame('', $timestamp);
        $payload = $timestamp.$request->getMethod().$request->getRequestTarget().(string) $request->getBody();
        $this->assertSame(
            base64_encode(hash_hmac('sha256', $payload, 'test-secret', true)),
            $request->getHeaderLine('OK-ACCESS-SIGN')
        );
    }

    public static function orderBodies(): array
    {
        return [
            'empty JSON object' => [[], '{}'],
            'Chinese text' => [['tag' => '测试'], '{"tag":"测试"}'],
        ];
    }
}
