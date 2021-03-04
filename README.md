## EasyExchange
- 方便使用的数据货币交易所SDK，包含币安(Binance)，火币(Huobi)，欧易(Okex)
- [接口列表](api.md)
- [English Doc](README_EN.md)

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

## 说明

#### 币安
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
];

$app = Factory::binance($config['binance']);
```

1. 市场行情相关
```php
$app = Factory::binance($config['binance']);
// 深度信息
$app->market->depth('LTCBTC');
// 近期成交列表
$app->market->trades('ETHBTC', 10);
// 查询历史成交
$app->market->historicalTrades('ETHBTC', 10);
// 近期成交
$app->market->aggTrades('ETHBTC');
// 24hr 价格变动情况
$app->market->hr24('ETHBTC');
// K线数据
$params = [
    'symbol' => 'ETHBTC',
    'interval' => 'DAY',
    'startTime' => '时间戳',
    'endTime' => '时间戳',
    'limit' => 10,
]; // 详见币安文档
$app->market->kline($params);
// 当前平均价格
$app->market->avgPrice('ETHBTC');
// 获取交易对最新价格
$app->market->price('ETHBTC');
// 返回当前最优的挂单(最高买单，最低卖单)
$app->market->bookTicker('ETHBTC');
```

2. 钱包相关
```php
// 获取所有币信息
$app->market->getAll();
// 查询每日资产快照
$params = []; // 具体值详见对应api文档
$app->market->accountSnapshot($params);
// 关闭站内划转
$app->market->disableFastWithdrawSwitch($params);
// 开启站内划转
$app->market->enableFastWithdrawSwitch($params);
```

3. 现货交易相关
```php
$app->spot;
```

4. 杠杆交易相关
```php
$app->margin;
```

5. 合约交易相关
```php
$app->future;
```

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
