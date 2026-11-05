<?php

namespace EasyExchange\Tests\Huobi\Socket;

use EasyExchange\Factory;
use EasyExchange\Huobi\Socket\Handle;
use PHPUnit\Framework\TestCase;

class MessageCacheTest extends TestCase
{
    public function testChannelDataReadsPlainAndCompressedMessages(): void
    {
        $app = Factory::huobi([
            'base_uri' => 'https://huobi.example',
            'websocket' => ['listen_ip' => '127.0.0.1', 'listen_port' => 2207],
        ]);
        $cache = new class {
            public array $huobi_list_orders = [];

            public function add($key, $value): void
            {
                $this->$key = $value;
            }

            public function cas($key, $old, $new): bool
            {
                if ($this->$key !== $old) {
                    return false;
                }

                $this->$key = $new;

                return true;
            }
        };
        $socket = $app->websocket;
        $socket->client = $cache;
        $handle = new Handle();
        $plain = '{"ch":"orders","action":"push","data":{"id":1}}';
        $compressed = '{"ch":"orders","action":"push","data":{"id":2}}';

        $this->expectOutputString($plain.PHP_EOL.$compressed.PHP_EOL);
        $handle->onMessage(null, $cache, [], $plain);
        $this->assertSame(['orders' => [$plain]], $socket->getChannelData(['orders']));
        $handle->onMessage(null, $cache, [], gzencode($compressed));
        $this->assertSame(['orders' => [$compressed, $plain]], $socket->getChannelData(['orders']));
    }
}
