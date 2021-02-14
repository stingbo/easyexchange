## PHP Easy Exchange Api
- easy use digital currency exchange api,include binance, okex, huobi pro etc
- [API list](api.md)

## Requirement

1. PHP >= 7.2
2. **[Composer](https://getcomposer.org/)**

## Installation

```shell
$ composer require "stingbo/easyexchange" -vvv
```

## Usage

```php
<?php

use EasyExchange\Factory;

$config = [
    'binance' => [
        'response_type' => 'array',
        'base_uri' => 'https://api.binance.com',
        'app_key' => 'shHA0alQvCXF0Rud',
        'secret' => '1yExlmnwB1sRZU6XF',
    ],
    'huobi' => [
        'response_type' => 'array',
        'base_uri' => 'https://api.huobi.pro',
        'app_key' => 'vmPUZE6mv9SD5VNH',
        'secret' => 'NhqPtmdSJYdKjVHjA',
    ],
    'okex' => [
        'response_type' => 'array',
        'base_uri' => 'https://www.okexcn.com',
        'app_key' => 'vmPUZE6mv9SD5V',
        'secret' => 'NhqPtmdSJYdKjVH',
    ],
];

$app = Factory::binance($config['binance']);
$app->market->depth('ETHBTC', 10);

// or
$app = Factory::huobi($config['huobi']);
$app->market->depth('btcusdt', 'step0', 5);

// or
$app = Factory::okex($config['okex']);
$app->market->depth('BTC-USD-SWAP', 5);
```
