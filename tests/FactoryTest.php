<?php

namespace EasyExchange\Tests;

use EasyExchange\Factory;

class FactoryTest extends TestCase
{
    public function testStaticCall()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.binance.com',
                'app_key' => 'xxxxxx',
                'secret' => 'xxxxxx',
            ],
            'huobi' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.huobi.pro',
                'app_key' => 'xxxxxx',
                'secret' => 'xxxxxx',
            ],
            'okex' => [
                'response_type' => 'array',
                'base_uri' => 'https://www.okexcn.com',
                'app_key' => 'xxxxxx',
                'secret' => 'xxxxxx',
            ],
        ];
        $this->assertInstanceOf(
            \EasyExchange\Binance\Application::class,
            Factory::binance($config['binance'])
        );

        $this->assertInstanceOf(
            \EasyExchange\Huobi\Application::class,
            Factory::huobi($config['huobi'])
        );

        $this->assertInstanceOf(
            \EasyExchange\Okex\Application::class,
            Factory::okex($config['okex'])
        );
    }
}
