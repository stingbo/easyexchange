<?php

namespace EasyExchange\Tests\Kernel;

use EasyExchange\Kernel\BaseClient;
use EasyExchange\Kernel\ServiceContainer;
use EasyExchange\Kernel\Socket\BaseClient as WebSocketClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BaseClientContractTest extends TestCase
{
    public function testHttpBaseClientCanSendAPublicRequest(): void
    {
        $app = new ServiceContainer(['base_uri' => 'https://exchange.example']);
        $handler = new MockHandler([new Response(200, [], '{"status":"ok"}')]);
        $app->rebind('guzzle_handler', $handler);

        $client = new BaseClient($app);
        $this->assertSame(['status' => 'ok'], $client->httpGet('/status'));
        $this->assertSame('https://exchange.example/status', (string) $handler->getLastRequest()->getUri());
    }

    public function testWebSocketSubclassCanUseDefaultStartupHooks(): void
    {
        $app = new ServiceContainer([
            'base_uri' => 'https://exchange.example',
            'websocket' => ['listen_ip' => '127.0.0.1', 'listen_port' => 2207],
        ]);
        $client = new class($app) extends WebSocketClient {
            public function runStartupHooks($connection): void
            {
                $this->ping($connection);
                $this->connect($connection);
            }
        };

        // The optional hooks must work without scheduling timers or touching the connection.
        $connection = new \stdClass();
        $client->runStartupHooks($connection);
        $this->assertSame([], get_object_vars($connection));
    }
}
