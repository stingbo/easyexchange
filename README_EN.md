## PHP Easy Exchange Api
- easy use digital currency exchange sdk, include binance, okex, huobi pro etc
- [API List | 接口列表](api.md)

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
        //'base_uri' => 'https://api.binance.com', // 正式网
        'base_uri' => 'https://testnet.binance.vision', // 测试网
        'app_key' => 'your app key',
        'secret' => 'your secret',
    ],
    'huobi' => [
        'response_type' => 'array',
        'base_uri' => 'https://api.huobi.pro',
        'app_key' => 'your app key',
        'secret' => 'your secret',
    ],
    'okex' => [
        'response_type' => 'array',
        'base_uri' => 'https://www.okexcn.com',
        'app_key' => 'your app key',
        'secret' => 'your secret',
    ],
];

$app = Factory::binance($config['binance']);
$params = [
    'symbol' => 'LTCUSDT',
    'side' => 'SELL', //BUY or SELL
    'type' => 'LIMIT',
    'timeInForce' => 'GTC',
    'quantity' => 0.1,
    'price' => 180,
    'recvWindow' => 10000,
];
$response = $app->trade->order($params);
$params = [
    'symbol' => 'LTCUSDT',
    'orderId' => 3948,
    'recvWindow' => 10000,
];
//$response = $app->trade->get($params);
$params = [
    'symbol' => 'LTCUSDT',
    'recvWindow' => 10000,
];
//$response = $app->trade->openOrders();
//$response = $app->trade->allOrders($params);

$params = [
    'symbol' => 'LTCUSDT',
    'orderId' => 3946,
    'recvWindow' => 10000,
];
//$response = $app->trade->cancelOrder($params);
//$response = $app->trade->cancelOrders('LTCUSDT');

//$response = $app->basic->ping();
//$response = $app->basic->systemTime();
//$response = $app->basic->exchangeInfo();
//$response = $app->basic->systemStatus();

//$response = $app->market->depth('LTCBTC');
//$response = $app->market->trades('ETHBTC', 10);
//$response = $app->market->historicalTrades('ETHBTC', 10);
//$response = $app->market->aggTrades('ETHBTC');

//$response = $app->wallet->getAll();
//$response = $app->wallet->account();
$params = [
    'type' => 'SPOT',
];
//$response = $app->wallet->accountSnapshot($params);

// huobi 火币--------------------------------------------
$app = Factory::huobi($config['huobi']);
//$response = $app->basic->systemTime();
//$response = $app->basic->exchangeInfo();
//$response = $app->basic->systemStatus();
//$response = $app->basic->currencys();
//$response = $app->basic->symbols();

$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
    'type' => 'buy-limit',
    'amount' => 0.001,
    'price' => 10000,
];
//$response = $app->trade->order($params);
//$response = $app->trade->cancelOrder('204533841408061');
$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
//    'side' => 'both',
];
//$response = $app->trade->openOrders($params);

//$response = $app->market->trades('btcusdt');
//$response = $app->market->depth('btcusdt', 'step0', 5);
//$response = $app->market->marketStatus();
//$response = $app->market->exchangeInfo();


//$response = $app->wallet->accounts();
//$response = $app->wallet->account(360218);
//$response = $app->wallet->assetValuation();
$params = [
    'account-id' => 3600000,
];
//$response = $app->wallet->history($params);
//$response = $app->wallet->depositAddress('btc');
$params = [
    'currency' => 'xrp',
];
//$response = $app->wallet->withdrawAddress($params);

// okex 欧易--------------------------------------------
$app = Factory::okex($config['okex']);
//$response = $app->basic->systemTime();
//$response = $app->basic->exchangeInfo('SPOT');

//$response = $app->market->depth('BTC-USD-SWAP', 5);

print_r($response);
```
