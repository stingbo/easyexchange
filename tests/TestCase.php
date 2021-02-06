<?php

namespace EasyExchange\Tests;

include __DIR__.'/../vendor/autoload.php';

use EasyExchange\Factory;

class TestCase
{
    public function order()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.binance.com',
                'app_key' => 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A',
                'secret' => 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j',
            ],
            'huobi' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.binance.com',
                'app_key' => 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A',
                'secret' => 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j',
            ],
            'okex' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.binance.com',
                'app_key' => 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A',
                'secret' => 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j',
            ],
        ];

        $app = Factory::binance($config['binance']);
//        $response = $app->order->doOrder('ETHBTC');
        $response = $app->market->depth('ETHBTC');
        print_r($response);
//        print_r($response);

        return 0;
    }
}

$tc = new TestCase();
$tc->order();
