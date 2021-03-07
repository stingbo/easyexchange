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

1. 基础信息
```php
// 测试服务器连通性
$app->basic->ping();
// 获取服务器时间
$app->basic->systemTime();
// 交易规范信息
$app->basic->exchangeInfo();
// 系统状态
$app->basic->systemStatus();
```

2. 用户信息
```php
// 获取BNB抵扣开关状态
$app->user->getBnbBurnStatus();
// 现货交易和杠杆利息BNB抵扣开关
$app->user->bnbBurn();
```

3. 市场行情相关
```php
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

4. 钱包相关
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

5. 现货交易相关
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

6. 杠杆交易相关
```php
// 全仓杠杆账户划转
$app->margin->transfer($params);
// 杠杆账户借贷
$app->margin->loan($params);
// 杠杆账户归还借贷
$app->margin->repay($params);
// 查询杠杆资产
$asset = 'BNB';
$app->margin->asset($asset);
// 获取所有杠杆资产信息
$app->margin->allAssets();
// 查询全仓杠杆交易对
$symbol = 'LTCUSDT';
$app->margin->pair($symbol);
// 获取所有全仓杠杆交易对
$app->margin->allPairs();
// 查询杠杆价格指数
$app->margin->priceIndex($symbol);
// 杠杆账户下单
$app->margin->order($params);
// 杠杆账户撤销订单
$app->margin->cancelOrder($params);
// 杠杆账户撤销单一交易对的所有挂单
$app->margin->cancelOrders($params);
// 获取全仓杠杆划转历史
$app->margin->transferHistory($params);
// 查询借贷记录
$app->margin->loanHistory($params);
// 查询还贷记录
$app->margin->repayHistory($params);
// 获取利息历史
$app->margin->interestHistory($params);
// 获取账户强制平仓记录
$app->margin->forceLiquidationRec($params);
// 查询全仓杠杆账户详情
$app->margin->account();
// 查询杠杆账户订单
$app->margin->get($params);
// 查询杠杆账户挂单记录
$app->margin->openOrders($params);
// 查询杠杆账户的所有订单
$app->margin->allOrders($params);
// 查询杠杆账户交易历史
$app->margin->myTrades($params);
// 查询账户最大可借贷额度
$app->margin->maxBorrowable($params);
// 查询最大可转出额
$app->margin->maxTransferable($params);
// 创建杠杆逐仓账户
$app->margin->create($params);
// 杠杆逐仓账户划转
$app->margin->isolatedTransfer($params);
// 获取杠杆逐仓划转历史
$app->margin->isolatedTransferHistory($params);
// 查询杠杆逐仓账户信息
$app->margin->isolatedAccount($symbol);
// 查询逐仓杠杆交易对
$app->margin->isolatedPair($symbol);
// 获取所有逐仓杠杆交易对
$app->margin->isolatedAllPairs();
```

7. 合约交易相关
```php
// 合约资金划转
$app->future->transfer($params);
// 获取合约资金划转历史
$app->future->transferHistory($params);
// 混合保证金借款
$app->future->borrow($params);
// 混合保证金借款历史
$app->future->borrowHistory($params);
// 混合保证金还款
$app->future->repay($params);
// 混合保证金还款历史
$app->future->repayHistory($params);
// 混合保证金钱包 v1 & v2，默认为v1，下同
$version = 'v1';
$app->future->wallet($version);
// 混合保证金信息 v1 & v2，默认为v1，下同
$app->future->configs($params, $version);
// 计算调整后的混合保证金质押率 v1 & v2
$app->future->calcAdjustLevel($params, $version);
// 可供调整混合保证金质押率的最大额 v1 & v2
$app->future->calcMaxAdjustAmount($params, $version);
// 调整混合保证金质押率 v1 & v2
$app->future->adjustCollateral($params, $version);
// 混合保证金调整质押率历史
$app->future->adjustCollateralHistory($params);
// 混合保证金强平历史
$app->future->liquidationHistory($params);
// 混合保证金抵押物还款上下限
$app->future->collateralRepayLimit($params);
// 获取混合保证金抵押物还款兑换比率
$app->future->getCollateralRepay($params);
// 混合保证金抵押物还款
$quoteId = '8a03da95f0ad4fdc8067e3b6cde72423';
$app->future->collateralRepay($quoteId);
// 混合保证金抵押物还款结果
$app->future->collateralRepayResult($quoteId);
// 混合保证金利息收取历史
$app->future->interestHistory($params);
```

8. 矿池相关
```php
// 获取算法
$app->pool->algoList();
// 获取币种
$app->pool->coinList();
// 请求矿工列表明细
$app->pool->workerDetail($params);
// 请求矿工列表
$app->pool->workerList($params);
// 收益列表
$app->pool->paymentList($params);
// 其他收益列表
$app->pool->paymentOther($params);
// 算力转让详情列表
$app->pool->hashTransferConfigDetails($params);
// 算力转让列表
$app->pool->hashTransferConfigDetailsList($params);
// 算力转让详情
$app->pool->hashTransferProfitDetails($params);
// 算力转让请求
$app->pool->hashTransferConfig($params);
// 取消算力转让设置
$app->pool->hashTransferConfigCancel($params);
// 统计列表
$app->pool->userStatus($params);
// 账号列表
$app->pool->userList($params);
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

1. 基础信息
```php
// 系统状态
$app->basic->systemStatus();
// 获取当前市场状态
$app->basic->marketStatus();
// 获取所有交易对
$app->basic->exchangeInfo();
// 获取所有币种
$app->basic->currencys();
// APIv2 币链参考信息
$app->basic->currencies();
// 获取当前系统时间戳
$app->basic->systemTime();
// 获取当前市场状态
$app->basic->marketStatus();
```

2. 用户信息
```php
// 账户信息
$app->user->accounts();
// 账户余额
$account_id = 360218;
$app->user->balance($account_id);
// 获取账户资产估值
$params = []; // 具体值详见对应api文档，下同
$app->user->assetValuation($params);
// 资产划转
$app->user->transfer($params);
// 账户流水
$app->user->history($params);
// 财务流水
$app->user->ledger($params);
// 币币现货账户与合约账户划转
$app->user->futuresTransfer($params);
// 点卡余额查询
$app->user->point($params);
// 点卡划转
$app->user->pointTransfer($params);
```

```php
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
$app->basic->systemTime();
$app->basic->exchangeInfo('SPOT');

$app->market->depth('BTC-USD-SWAP', 5);
```
