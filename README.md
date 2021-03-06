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

## 使用说明

### 币安
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
$params = []; // 具体值详见对应api文档，下同
$app->market->accountSnapshot($params);
// 关闭站内划转
$app->market->disableFastWithdrawSwitch($params);
// 开启站内划转
$app->market->enableFastWithdrawSwitch($params);
// 提币-Submit a withdraw request
$app->market->withdrawApply($params);
// 提币-提交提现请求
$app->market->withdraw($params);
// 获取充值历史(支持多网络)
$app->market->capitalDepositHistory($params);
// 获取充值历史
$app->market->depositHistory($params);
// 获取提币历史
$app->market->capitalWithdrawHistory($params);
// 获取提币历史
$app->market->withdrawHistory($params);
// 获取充值地址 (支持多网络)
$app->market->capitalDepositAddress($params);
// 获取充值地址
$app->market->depositAddress($params);
// 账户状态
$app->market->accountStatus();
// 账户API交易状态
$app->market->apiTradingStatus();
// 小额资产转换BNB历史
$app->market->userAssetDribbletLog();
// 小额资产转换
$asset = []; //币安文档上写的:ARRAY,正在转换的资产。例如：asset = BTC＆asset = USDT
$app->market->assetDust($asset);
// 资产利息记录
$app->market->assetDividend($params);
// 上架资产详情
$app->market->assetDetail();
// 交易手续费率查询
$app->market->tradeFee();
// 用户万向划转
$app->market->transfer($params);
// 查询用户万向划转历史
$app->market->transferHistory($params);
```

3. 现货交易相关
```php
// 测试下单
$params = [
    'symbol' => 'LTCUSDT',
    'side' => 'SELL', //BUY or SELL
    'type' => 'LIMIT',
    'timeInForce' => 'GTC',
    'quantity' => 0.1,
    'price' => 180,
    'recvWindow' => 10000,
];
$app->spot->orderTest($params);
// 下单
$params = [
    'symbol' => 'LTCUSDT',
    'side' => 'SELL', //BUY or SELL
    'type' => 'LIMIT',
    'timeInForce' => 'GTC',
    'quantity' => 0.1,
    'price' => 180,
    'recvWindow' => 10000,
];
$app->spot->order($params);
// 获取交易对的所有当前挂单
$app->spot->openOrders('ETHBTC');
// 撤销订单
$params = [
    'symbol' => 'LTCUSDT',
    'orderId' => 3946,
    'recvWindow' => 10000,
];
$app->spot->cancelOrder($params);
// 撤销单一交易对的所有挂单
$app->spot->cancelOrders('ETHBTC');
// 查询订单
$params = []; // 具体值详见对应api文档，下同
$app->spot->get($params);
// 获取所有帐户订单； 有效，已取消或已完成
$app->spot->allOrders($params);
// 获取账户指定交易对的成交历史
$params = []; // 具体值详见对应api文档，下同
$app->spot->myTrades($params);
// OCO下单
$params = []; // 具体值详见对应api文档，下同
$app->spot->oco($params);
// 取消 OCO 订单
$params = []; // 具体值详见对应api文档，下同
$app->spot->cancelOcoOrder($params);
// 查询 OCO
$params = []; // 具体值详见对应api文档，下同
$app->spot->getOcoOrder($params);
// 查询所有 OCO
$params = []; // 具体值详见对应api文档，下同
$app->spot->allOrderList($params);
// 查询 OCO 挂单
$app->spot->openOrderList($params);
```

4. 杠杆交易相关
```php
$app->margin;
```

5. 合约交易相关
```php
$app->future;
```

### 火币
```php
<?php

use EasyExchange\Factory;

// 配置
$config = [
    'huobi' => [
        'response_type' => 'array',
        'base_uri' => 'https://api.huobi.pro',
        'app_key' => 'your app key',
        'secret' => 'your secret',
    ],
];

$app = Factory::houbi($config['houbi']);
```

```php
$app = Factory::huobi($config['huobi']);
$app->basic->systemTime();
$app->basic->exchangeInfo();
$app->basic->systemStatus();
$app->basic->currencys();
$app->basic->symbols();

$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
    'type' => 'buy-limit',
    'amount' => 0.001,
    'price' => 10000,
];
$app->spot->order($params);
$app->spot->cancelOrder('204533841408061');
$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
//    'side' => 'both',
];
$app->spot->openOrders($params);

$app->market->trades('btcusdt');
$app->market->depth('btcusdt', 'step0', 5);
$app->market->marketStatus();
$app->market->exchangeInfo();


$app->wallet->accounts();
$app->wallet->account(360218);
$app->wallet->assetValuation();
$params = [
    'account-id' => 3600000,
];
$app->wallet->history($params);
$app->wallet->depositAddress('btc');
$params = [
    'currency' => 'xrp',
];
$app->wallet->withdrawAddress($params);
```

### 欧易
```php
<?php

use EasyExchange\Factory;

// 配置
$config = [
    'okex' => [
        'response_type' => 'array',
        'base_uri' => 'https://www.okexcn.com',
        'app_key' => 'your app key',
        'secret' => 'your secret',
    ],
];

$app = Factory::okex($config['okex']);
```

```php
$app = Factory::okex($config['okex']);
$app->basic->systemTime();
$app->basic->exchangeInfo('SPOT');

$app->market->depth('BTC-USD-SWAP', 5);
```
