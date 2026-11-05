<?php

namespace EasyExchange\Tests;

use EasyExchange\Factory;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class SigningTimezoneTest extends TestCase
{
    public function testOkxRestSigningPreservesTimezone(): void
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

        $this->assertUtcTimestampWithoutTimezoneChange(function () use ($app, $handler) {
            $app->user->config();

            return $handler->getLastRequest()->getHeaderLine('OK-ACCESS-TIMESTAMP');
        }, '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{3}Z$/');
    }

    public function testHuobiRestSigningPreservesTimezone(): void
    {
        $app = Factory::huobi([
            'base_uri' => 'https://huobi.example',
            'app_key' => 'test-key',
            'secret' => 'test-secret',
        ]);
        $handler = new MockHandler([new Response(200, [], '{}')]);
        $app->rebind('guzzle_handler', $handler);
        $app->rebind('logger', new NullLogger());

        $this->assertUtcTimestampWithoutTimezoneChange(function () use ($app, $handler) {
            $app->user->accounts();
            parse_str($handler->getLastRequest()->getUri()->getQuery(), $query);

            return $query['Timestamp'];
        });
    }

    public function testHuobiWebSocketAuthPreservesTimezone(): void
    {
        $app = Factory::huobi([
            'base_uri' => 'https://huobi.example',
            'app_key' => 'test-key',
            'secret' => 'test-secret',
            'websocket' => ['listen_ip' => '127.0.0.1', 'listen_port' => 2207],
        ]);
        $connection = new class {
            public $message;

            public function send($message): void
            {
                $this->message = $message;
            }
        };

        $this->assertUtcTimestampWithoutTimezoneChange(function () use ($app, $connection) {
            $app->websocket->auth($connection);

            return json_decode($connection->message, true)['params']['timestamp'];
        });
    }

    private function assertUtcTimestampWithoutTimezoneChange(
        callable $sign,
        string $format = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/'
    ): void {
        $originalTimezone = date_default_timezone_get();
        try {
            date_default_timezone_set('Asia/Shanghai');
            $before = time();
            $timestamp = $sign();
            $after = time();

            $this->assertSame('Asia/Shanghai', date_default_timezone_get());
            $this->assertMatchesRegularExpression($format, $timestamp);
            $epoch = (new \DateTimeImmutable($timestamp, new \DateTimeZone('UTC')))->getTimestamp();
            $this->assertGreaterThanOrEqual($before, $epoch);
            $this->assertLessThanOrEqual($after, $epoch);
        } finally {
            date_default_timezone_set($originalTimezone);
        }
    }
}
