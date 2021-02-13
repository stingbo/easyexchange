<?php

namespace EasyExchange\Tests;

include __DIR__.'/../vendor/autoload.php';

use EasyExchange\Factory;

class TC
{
    public function test()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.binance.com',
                'app_key' => 'shHA0alQvCXF0RudlKyzyQzHSv9qgiULUtWEh8RyvlVQ6XCoqupDYuFuyL9ReNHs',
                'secret' => '1yExlmnwB1sRZU6XFddkSyVMQtmUTCGkB86plXpAC5moqRh5zdpt4Ad1jMCvk2nw',
            ],
            'huobi' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.huobi.pro',
                'app_key' => 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A',
                'secret' => 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j',
            ],
            'okex' => [
                'response_type' => 'array',
                'base_uri' => 'https://www.okexcn.com',
                'app_key' => 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A',
                'secret' => 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j',
            ],
        ];

//        $app = Factory::binance($config['binance']);
//        $response = $app->market->depth('ETHBTC');
        //$response = $app->order->doOrder('ETHBTC');
        //$response = $app->market->trades('ETHBTC', 10);
        //$response = $app->market->historicalTrades('ETHBTC', 10);
        //$response = $app->market->aggTrades('ETHBTC');

        $app = Factory::huobi($config['huobi']);
        $response = $app->market->depth('btcusdt', 'step0', 5);
//        $response = $app->market->trades('btcusdt');
//        $response = $app->market->exchangeInfo();

//        $app = Factory::okex($config['okex']);
//        $response = $app->market->depth('BTC-USD-SWAP', 5);

        print_r($response);

        return 0;
    }
}

$tc = new TC();
$tc->test();
