## EasyExchange
- 方便使用的数据货币交易所SDK，包含币安(Binance)，火币(Huobi)，欧易(Okex)
- [接口列表](api.md)
- [English](README_EN.md)

## 依赖

1. PHP >= 7.2
2. **[Composer](https://getcomposer.org/)**

## 安装

```shell
$ composer require "stingbo/easyexchange" -vvv
```

## 约束

1. 对应平台接口，在大于或等于三个参数以上的，使用数组传入，否则使用同名参数传入
2. 币安的 timestamp 参数已内置，不需要额外传入
3. 火币的 AccessKeyId,SignatureMethod,SignatureVersion,Timestamp 已内置，不需要额外传入

## 使用

```php
<?php

use EasyExchange\Factory;

// 配置
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
// 下单
$response = $app->spot->order($params);

// 获取单据信息
$params = [
    'symbol' => 'LTCUSDT',
    'orderId' => 3948,
    'recvWindow' => 10000,
];
$response = $app->spot->get($params);

// 当前挂单
$response = $app->spot->openOrders();

$params = [
    'symbol' => 'LTCUSDT',
    'recvWindow' => 10000,
];
//$response = $app->spot->allOrders($params);

$params = [
    'symbol' => 'LTCUSDT',
    'orderId' => 3946,
    'recvWindow' => 10000,
];
//$response = $app->spot->cancelOrder($params);
//$response = $app->spot->cancelOrders('LTCUSDT');

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
//$response = $app->spot->order($params);
//$response = $app->spot->cancelOrder('204533841408061');
$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
//    'side' => 'both',
];
//$response = $app->spot->openOrders($params);

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
