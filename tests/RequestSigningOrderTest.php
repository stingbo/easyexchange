<?php

namespace EasyExchange\Tests;

use EasyExchange\Factory;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class RequestSigningOrderTest extends TestCase
{
    /**
     * @dataProvider requestOrders
     */
    public function testSigningFollowsEachRequest(string $exchange, string $module, array $modes): void
    {
        $app = Factory::make($exchange, [
            'base_uri' => "https://{$exchange}.example",
            'app_key' => 'test-key',
            'secret' => $exchange === 'coinbase' ? base64_encode('test-secret') : 'test-secret',
            'passphrase' => 'test-passphrase',
            'x-simulated-trading' => '0',
        ]);
        $handler = new MockHandler([new Response(200, [], '{}'), new Response(200, [], '{}')]);
        $app->rebind('guzzle_handler', $handler);
        $app->rebind('logger', new NullLogger());
        $client = $app->$module;

        foreach ($modes as $mode) {
            $path = $mode === 'SIGN' ? '/private' : '/public';
            $client->httpGet($path, ['limit' => 1], $mode);
            $request = $handler->getLastRequest();
            $this->assertSame($path, $request->getUri()->getPath());
            parse_str($request->getUri()->getQuery(), $query);
            $this->assertSame('1', $query['limit']);

            if ($exchange === 'huobi') {
                if ($mode === 'NONE') {
                    $this->assertSame(['limit' => '1'], $query);
                    continue;
                }

                $this->assertSame('test-key', $query['AccessKeyId'] ?? null);
                $this->assertNotEmpty($query['Timestamp'] ?? null);
                $signature = $query['Signature'] ?? '';
                unset($query['Signature']);
                ksort($query);
                $payload = implode("\n", ['GET', $request->getUri()->getHost(), $path, http_build_query($query)]);
            } else {
                $prefix = $exchange === 'okex' ? 'OK-ACCESS-' : 'CB-ACCESS-';
                if ($mode === 'NONE') {
                    foreach (['KEY', 'PASSPHRASE', 'TIMESTAMP', 'SIGN'] as $header) {
                        $this->assertFalse($request->hasHeader($prefix.$header));
                    }
                    continue;
                }

                $this->assertSame('test-key', $request->getHeaderLine($prefix.'KEY'));
                $this->assertSame('test-passphrase', $request->getHeaderLine($prefix.'PASSPHRASE'));
                $timestamp = $request->getHeaderLine($prefix.'TIMESTAMP');
                $this->assertNotSame('', $timestamp);
                $signature = $request->getHeaderLine($prefix.'SIGN');
                $payload = $timestamp.'GET'.$request->getRequestTarget();
            }

            $this->assertSame(base64_encode(hash_hmac('sha256', $payload, 'test-secret', true)), $signature);
        }
    }

    public static function requestOrders(): array
    {
        $cases = [];
        foreach (['okex' => 'market', 'huobi' => 'market', 'coinbase' => 'user', 'bittrex' => 'market'] as $exchange => $module) {
            $cases[$exchange.' public then private'] = [$exchange, $module, ['NONE', 'SIGN']];
            $cases[$exchange.' private then public'] = [$exchange, $module, ['SIGN', 'NONE']];
        }

        return $cases;
    }
}
