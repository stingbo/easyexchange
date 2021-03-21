## EasyExchange
- 方便使用的数据货币交易所SDK，包含币安(Binance)，火币(Huobi)，欧易(Okex)
- [English Doc](README_EN.md)
- [API List](api.md)

## 依赖

1. PHP >= 7.2
2. **[Composer](https://getcomposer.org/)**

## 安装

```shell
$ composer require "stingbo/easyexchange" -vvv
```

## 约定

1. 你已非常熟悉了项目里接入平台的API文档
2. 大于或等于三个参数以上的，使用数组传入，否则使用同名参数传入
3. 接口名称不一定和对应平台的一致，多个平台类似的接口，我做了统一，但参数需要传入平台对应的名称
4. 币安的 timestamp 参数已内置，不需要额外传入
5. 火币的 AccessKeyId,SignatureMethod,SignatureVersion,Timestamp 已内置，不需要额外传入

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

2. 账户信息
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
$app->market->disableFastWithdrawSwitch();
// 开启站内划转
$app->market->enableFastWithdrawSwitch();
// 提币[SAPI]-Submit a withdraw request
$app->market->withdrawApply($params);
// 提币[WAPI]-提交提现请求
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
```

2. 账户信息
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
$app->user->point($subUid = '');
// 点卡划转
$app->user->pointTransfer($params);
```

3. 市场行情相关
```php
// K 线数据（蜡烛图）
$params = [
    'symbol' => 'btcusdt',
    'period' => '5min',
];
$app->market->kline($params);
// 聚合行情（Ticker）
$app->market->aggTrades($symbol);
// 所有交易对的最新 Tickers
$app->market->tickers();
// 市场深度数据
$app->market->depth($params);
// 最近市场成交记录
$app->market->trades($symbol);
// 获得近期交易记录
$app->market->historicalTrades($symbol);
// 最近24小时行情数据
$app->market->hr24($symbol);
// 获取杠杆ETP实时净值
$app->market->etp($symbol);
```

4. 钱包相关
```php
// 充币地址查询
$currency = 'btc';
$app->wallet->depositAddress($currency);
// 提币额度查询
$app->wallet->withdrawQuota($currency);
// 充币地址查询
$params = [
    'currency' => 'xrp',
];
$app->wallet->withdrawAddress($params);
// 虚拟币提币
$app->wallet->withdraw($params);
// 取消提币
$app->wallet->cancelWithdraw($params);
// 充提记录
$app->wallet->depositHistory($params);
```

5. 现货/杠杆交易相关
```php
// 下单
$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
    'type' => 'buy-limit',
    'amount' => 0.001,
    'price' => 10000,
];
$app->trade->order($params);
// 撤销订单
$app->trade->cancelOrder('204533841408061');
// 查询当前未成交订单
$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
//    'side' => 'both',
];
$app->trade->openOrders($params);
// 批量下单
$app->trade->batchOrders($params);
// 撤销订单（基于client order ID）
$client_order_id = 'a0001';
$app->trade->cancelClientOrder($client_order_id);
// 自动撤销订单
$timeout = 10;
$app->trade->cancelAllAfter($timeout);
// 批量撤销所有订单
$app->trade->batchCancelOpenOrders($params);
// 批量撤销指定订单
$order_ids = ['5983466', '5722939', '5721027'];
$app->trade->batchCancel($order_ids);
// 查询订单详情
$order_id = '59378';
$app->trade->get($order_id);
// 查询订单详情（基于client order ID）
$order_client_id = 'a0001';
$app->trade->getClientOrder($order_client_id);
// 成交明细
$app->trade->matchResult($order_id);
// 搜索历史订单
$app->trade->getOrders($params);
// 搜索最近48小时内历史订单
$app->trade->hr48History($params);
// 当前和历史成交
$app->trade->matchResults($params);
// 获取用户当前手续费率
$symbols = 'btcusdt,ethusdt,ltcusdt';
$app->trade->transactFeeRate($symbols);
```

6. 借币（逐仓/全仓杠杆）
```php
// 归还借币（全仓逐仓通用）
$app->margin->repayment($params);
// 资产划转（逐仓）-从现货账户划转至逐仓杠杆账户.
$app->margin->transferIn($params);
// 资产划转（逐仓）-从逐仓杠杆账户划转至现货账户.
$app->margin->transferOut($params);
// 查询借币币息率及额度（逐仓）.
$app->margin->loanInfo($params);
// 申请借币（逐仓）.
$app->margin->orders($params);
// 归还借币（逐仓）.
$app->margin->repay($order_id, $amount);
// 查询借币订单（逐仓）.
$app->margin->loanOrders($params);
// 借币账户详情（逐仓）.
$app->margin->balance($symbol = '', $sub_uid = '');
// 资产划转（全仓）-从现货账户划转至全仓杠杆账.
$app->margin->crossTransferIn($currency, $amount);
// 资产划转（全仓）-从全仓杠杆账户划转至现货账户.
$app->margin->crossTransferOut($currency, $amount);
// 查询借币币息率及额度（全仓）.
$app->margin->crossLoanInfo();
// 申请借币（全仓）.
$app->margin->crossOrders($currency, $amount);
// 归还借币（全仓）.
$app->margin->crossRepay($order_id, $amount);
// 查询借币订单（全仓）.
$app->margin->crossLoanOrders($params);
// 借币账户详情（全仓）.
$app->margin->crossBalance($sub_uid = '');
// 还币交易记录查询（全仓）.
$app->margin->getRepayment($params);
```

7. 策略委托
```php
// 策略委托下单
$app->algo->order($params);
// 策略委托（触发前）撤单.
$app->algo->cancelOrder($clientOrderIds);
// 查询未触发OPEN策略委托.
$app->algo->openOrders($params);
// 查询策略委托历史.
$app->algo->orderHistory($params);
// 查询特定策略委托.
$app->algo->specific($clientOrderId);
```

8. 借币（C2C）
```php
// 借入借出下单
$app->c2c->order($params);
// 借入借出撤单.
$app->c2c->cancelOrder($params);
// 撤销所有借入借出订单.
$app->c2c->cancelAll($params);
// 查询借入借出订单.
$app->c2c->getOrders($params);
// 查询特定借入借出订单及其交易记录.
$app->c2c->get($offerId);
// 查询借入借出交易记录.
$app->c2c->transactions($params);
// 还币.
$app->c2c->repayment($params);
// 查询还币交易记录.
$app->c2c->getRepayment($params);
// 资产划转.
$app->c2c->transfer($params);
// 查询账户余额
$app->c2c->balance($accountId, $currency = '');
```

### 欧易 V5 版本
```php
<?php

use EasyExchange\Factory;

// 配置
$config = [
    'okex' => [
        'response_type' => 'array',
        'base_uri' => 'https://www.okex.com',
        'app_key' => 'your app key',
        'secret' => 'your secret',
        'passphrase' => 'your passphrase',
        'x-simulated-trading' => 1,
    ],
];

$app = Factory::okex($config['okex']);
```

1. 基础信息
```php
$params = [
    'instType' => 'SPOT',
];
// 获取交易产品基础信息
$app->basic->exchangeInfo($params);
// 获取交割和行权记录
$app->basic->deliveryExerciseHistory($params);
// 获取持仓总量
$app->basic->openInterest($params);
// 获取永续合约当前资金费率
$app->basic->fundingRate($instId);
// 获取永续合约历史资金费率
$app->basic->fundingRateHistory($params);
// 获取限价
$app->basic->priceLimit($instId);
// 获取期权定价
$app->basic->optSummary($uly, $expTime = '');
// 获取预估交割/行权价格
$app->basic->estimatedPrice($instId);
// 获取免息额度和币种折算率等级
$app->basic->discountRateInterestFreeQuota($ccy = '');
// 获取系统时间
$app->basic->systemTime();
// 获取平台公共爆仓单信息
$app->basic->liquidationOrders($params);
// 获取标记价格
$app->basic->markPrice($params);
```

2. 账户信息
```php
// 查看账户余额
$app->user->balance($ccy = '');
// 查看持仓信息
$app->user->positions($params);
// 账单流水查询（近七天）
$app->user->bills($params);
// 账单流水查询（近三个月）
$app->user->billsArchive($params);
// 查看账户配置
$app->user->config();
// 设置持仓模式
$app->user->setPositionMode($posMode);
// 设置杠杆倍数
$app->user->setLeverage($params);
// 获取最大可买卖/开仓数量
$app->user->maxSize($params);
// 获取最大可用数量
$app->user->maxAvailSize($params);
// 调整保证金
$app->user->marginBalance($params);
// 获取杠杆倍数
$app->user->leverageInfo($instId, $mgnMode);
// 获取交易产品最大可借
$app->user->maxLoan($params);
// 获取当前账户交易手续费费率
$app->user->tradeFee($params);
// 获取计息记录
$app->user->interestAccrued($params);
// 期权希腊字母PA/BS切换
$app->user->setGreeks($greeksType);
// 查看账户最大可转余额
$app->user->maxWithdrawal($ccy = '');
```

3. 市场行情相关
```php
// 获取所有产品行情信息
$app->market->tickers($instType, $uly = '');
// 获取单个产品行情信息
$app->market->ticker($instId);
// 获取指数行情
$app->market->indexTickers($quoteCcy = '', $instId = '');
// 获取产品深度
$instId = 'BTC-USD-SWAP';
$sz = 1
$app->market->depth($instId, $sz);
// 获取所有交易产品K线数据
$app->market->kline($params);
// 获取交易产品历史K线数据（仅主流币）
$app->market->klineHistory($params);
// 获取指数K线数据
$app->market->indexKline($params);
// 获取标记价格K线数据
$app->market->markPriceKline($params);
// 获取交易产品公共成交数据
$app->market->trades($instId, $limit = 100);
```

4. 资金相关
```php
// 获取充值地址信息
$app->wallet->depositAddress($ccy);
// 获取资金账户余额信息.
$app->wallet->balance($ccy = '');
// 资金划转.
$app->wallet->transfer($params);
// 提币.
$app->wallet->withdrawal($params);
// 充值记录.
$app->wallet->depositHistory($params = []);
// 提币记录.
$app->wallet->withdrawalHistory($params = []);
// 获取币种列表.
$app->wallet->currencies();
// 余币宝申购/赎回.
$app->wallet->purchaseRedempt($params);
// 资金流水查询.
$app->wallet->bills($params);
```

5. 交易相关
```php
$params = [
    'instId' => 'BTC-USD-190927-5000-C',
    'tdMode' => 'cash',
    'side' => 'buy',
    'ordType' => 'limit', // 限价单
    'sz' => '0.0001', // 委托数量
    'px' => '1000', // 委托价格，仅适用于限价单
];
// 下单
$app->trade->order($params);
// 批量下单.
$app->trade->batchOrders($params);
// 撤销之前下的未完成订单.
$app->trade->cancelOrder($params);
// 批量撤单.
$app->trade->cancelBatchOrders($params);
// 修改当前未成交的挂单.
$app->trade->amendOrder($params);
// 批量修改订单.
$app->trade->amendBatchOrders($params);
// 市价仓位全平.
$app->trade->closePosition($params);
$params = [
    'instId' => 'BTC-USD-190927-5000-C',
    'ordId' => '2510789768709120',
];
// 获取订单信息
$app->trade->get($params);
// 获取未成交订单列表.
$app->trade->openOrders($params);
// 获取历史订单记录（近七天）.
$app->trade->orderHistory($params);
// 获取历史订单记录（近三个月）.
$app->trade->orderHistoryArchive($params);
// 获取成交明细.
$app->trade->fills($params);
```

6. 策略委托
```php
// 策略委托下单
$app->algo->order($params);
// 撤销策略委托订单.
$app->algo->cancelOrder($params);
// 获取未完成策略委托单列表.
$app->algo->openOrders($params);
// 获取历史策略委托单列表.
$app->algo->orderHistory($params);
```