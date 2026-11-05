<?php

namespace EasyExchange\Tests\Gate\Spot;

use EasyExchange\Factory;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ClientTest extends TestCase
{
    /**
     * @dataProvider requestOrders
     */
    public function testSigningFollowsEachRequest(string $first, string $second): void
    {
        $app = Factory::gate([
            'base_uri' => 'https://gate.example',
            'app_key' => 'test-key',
            'secret' => 'test-secret',
        ]);
        $handler = new MockHandler([new Response(200, [], '[]'), new Response(200, [], '[]')]);
        $app->rebind('guzzle_handler', $handler);
        $app->rebind('logger', new NullLogger());

        $app->spot->$first();
        $firstRequest = $handler->getLastRequest();
        $app->spot->$second();
        $secondRequest = $handler->getLastRequest();

        [$publicRequest, $privateRequest] = $first === 'tickers'
            ? [$firstRequest, $secondRequest]
            : [$secondRequest, $firstRequest];

        $this->assertSame('/api/v4/spot/tickers', $publicRequest->getUri()->getPath());
        $this->assertFalse($publicRequest->hasHeader('KEY'));
        $this->assertFalse($publicRequest->hasHeader('Timestamp'));
        $this->assertFalse($publicRequest->hasHeader('SIGN'));

        $this->assertSame('/api/v4/spot/accounts', $privateRequest->getUri()->getPath());
        $this->assertSame('test-key', $privateRequest->getHeaderLine('KEY'));
        $timestamp = $privateRequest->getHeaderLine('Timestamp');
        $this->assertMatchesRegularExpression('/^\d+$/', $timestamp);
        $payload = implode("\n", [
            'GET',
            '/api/v4/spot/accounts',
            $privateRequest->getUri()->getQuery(),
            hash('sha512', ''),
            $timestamp,
        ]);
        $this->assertSame(hash_hmac('sha512', $payload, 'test-secret'), $privateRequest->getHeaderLine('SIGN'));
    }

    public static function requestOrders(): array
    {
        return [
            'public then private' => ['tickers', 'accounts'],
            'private then public' => ['accounts', 'tickers'],
        ];
    }
}
