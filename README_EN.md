## PHP Easy Exchange Api
- Easy use digital currency exchange SDK, include `Binance`, `OKEX`, `Huobi pro` etc
- [中文文档](README_CN.md)
- [接口列表](api.md)

## Requirement

1. PHP >= 7.2
2. **[Composer](https://getcomposer.org/)**

## Installation

```shell
$ composer require "stingbo/easyexchange" -vvv
```

## Agreement

1. You are very familiar with the API documentation of the access platform in the project
2. If it is greater than or equal to more than three parameters, use an array to pass in, otherwise use a parameter with the same name to pass in
3. The interface name is not necessarily consistent with the corresponding platform. I have unified the interfaces of multiple platforms, but the parameters need to be passed in the corresponding name of the platform
4. Binance's timestamp parameter is built-in, no additional input is required
5. Huobi’s AccessKeyId, SignatureMethod, SignatureVersion, and Timestamp are already built-in, no additional input is required

## Usage

### Binance
```php
<?php

use EasyExchange\Factory;

$config = [
    'binance' => [
        'response_type' => 'array',
        //'base_uri' => 'https://api.binance.com',
        'base_uri' => 'https://testnet.binance.vision', // testnet
        'app_key' => 'your app key',
        'secret' => 'your secret',
    ],
];

$app = Factory::binance($config['binance']);
```

1. Basic Information
```php
// Test Connectivity
$app->basic->ping();
// Check Server Time
$app->basic->systemTime();
// Exchange Information
$app->basic->exchangeInfo();
// System Status
$app->basic->systemStatus();
```

2. Account Information
```php
// Get BNB Burn Status
$app->user->getBnbBurnStatus();
// Toggle BNB Burn On Spot Trade And Margin Interest
$params = []; // For specific values, see the corresponding api document, the same below
$app->user->bnbBurn($params);
```

3. Market Data
```php
// Order Book
$symbol = 'ETHBTC';
$app->market->depth($symbol);
// Recent Trades List
$app->market->trades($symbol, 10);
// Old Trade Lookup
$app->market->historicalTrades($symbol, 10);
// Compressed/Aggregate Trades List
$app->market->aggTrades($symbol);
// Kline/Candlestick Data
$params = [
    'symbol' => 'ETHBTC',
    'interval' => 'DAY',
    'startTime' => 'timestamp',
    'endTime' => 'timestamp',
    'limit' => 10,
];
$app->market->kline($params);
// Current Average Price
$app->market->avgPrice($symbol);
// 24hr Ticker Price Change Statistics
$app->market->hr24($symbol);
// Symbol Price Ticker
$app->market->price($symbol);
// Symbol Order Book Ticker
$app->market->bookTicker($symbol);
```

4. Wallet
```php
// All Coins' Information
$app->market->getAll();
// Daily Account Snapshot
$params = []; // For specific values, see the corresponding api document, the same below
$app->market->accountSnapshot($params);
// Disable Fast Withdraw Switch
$app->market->disableFastWithdrawSwitch();
// Enable Fast Withdraw Switch
$app->market->enableFastWithdrawSwitch();
// Withdraw[SAPI]-Submit a withdraw request
$app->market->withdrawApply($params);
// Withdraw[WAPI]-Submit a withdraw request
$app->market->withdraw($params);
// Deposit History(supporting network)
$app->market->capitalDepositHistory($params);
// Deposit History
$app->market->depositHistory($params);
// Withdraw History(supporting network)
$app->market->capitalWithdrawHistory($params);
// Withdraw History
$app->market->withdrawHistory($params);
// Deposit Address (supporting network)
$app->market->capitalDepositAddress($params);
// Deposit Address
$app->market->depositAddress($params);
// Account Status
$app->market->accountStatus();
// Account API Trading Status
$app->market->apiTradingStatus();
// DustLog-Fetch small amounts of assets exchanged BNB records
$app->market->userAssetDribbletLog();
// Dust Transfer-Convert dust assets to BNB.
//It is written on the Binance document:ARRAY,the asset being converted. For example：asset = BTC＆asset = USDT
$asset = [];
$app->market->assetDust($asset);
// Asset Dividend Record
$app->market->assetDividend($params);
// Asset Detail
$app->market->assetDetail();
// Trade Fee
$app->market->tradeFee();
// User Universal Transfer
$app->market->transfer($params);
// Query User Universal Transfer History
$app->market->transferHistory($params);
```

5. Spot Trade
```php
// Test New Order
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
// New Order
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
// Cancel Order
$params = [
    'symbol' => 'LTCUSDT',
    'orderId' => 3946,
    'recvWindow' => 10000,
];
$app->spot->cancelOrder($params);
// Cancel all Open Orders on a Symbol
$app->spot->cancelOrders('ETHBTC');
// Query Order
$params = []; // For specific values, see the corresponding api document, the same below
$app->spot->get($params);
// Current Open Orders
$app->spot->openOrders('ETHBTC');
// All Orders-Get all account orders; active, canceled, or filled.
$app->spot->allOrders($params);
// New OCO
$app->spot->oco($params);
// Cancel OCO
$app->spot->cancelOcoOrder($params);
// Query OCO
$app->spot->getOcoOrder($params);
// Query all OCO
$app->spot->allOrderList($params);
// Query Open OCO
$app->spot->openOrderList($params);
// Account Trade List
$app->spot->myTrades($params);
```

6. Cross Margin Account Transfer
```php
// Cross Margin Account Transfer
$app->margin->transfer($params);
// Margin Account Borrow
$app->margin->loan($params);
// Margin Account Repay
$app->margin->repay($params);
// Query Margin Asset
$asset = 'BNB';
$app->margin->asset($asset);
// Query Cross Margin Pair
$symbol = 'LTCUSDT';
$app->margin->pair($symbol);
// Get All Margin Assets
$app->margin->allAssets();
// Get All Cross Margin Pairs
$app->margin->allPairs();
// Query Margin PriceIndex
$app->margin->priceIndex($symbol);
// Margin Account New Order
$app->margin->order($params);
// Margin Account Cancel Order
$app->margin->cancelOrder($params);
// Margin Account Cancel all Open Orders on a Symbol
$app->margin->cancelOrders($params);
// Get Cross Margin Transfer History
$app->margin->transferHistory($params);
// Query Loan Record
$app->margin->loanHistory($params);
// Query Repay Record
$app->margin->repayHistory($params);
// Get Interest History
$app->margin->interestHistory($params);
// Get Force Liquidation Record
$app->margin->forceLiquidationRec($params);
// Query Cross Margin Account Details
$app->margin->account();
// Query Margin Account's Order
$app->margin->get($params);
// Query Margin Account's Open Orders
$app->margin->openOrders($params);
// Query Margin Account's All Orders
$app->margin->allOrders($params);
// Query Margin Account's Trade List
$app->margin->myTrades($params);
// Query Max Borrow
$app->margin->maxBorrowable($params);
// Query Max Transfer-Out Amount
$app->margin->maxTransferable($params);
// Create Isolated Margin Account
$app->margin->create($params);
// Isolated Margin Account Transfer
$app->margin->isolatedTransfer($params);
// Get Isolated Margin Transfer History
$app->margin->isolatedTransferHistory($params);
// Query Isolated Margin Account Info
$app->margin->isolatedAccount($symbol);
// Query Isolated Margin Symbol
$app->margin->isolatedPair($symbol);
// Get All Isolated Margin Symbol
$app->margin->isolatedAllPairs();
// Query Margin Interest Rate History
$app->margin->interestRateHistory($params);
```

7. Futures
```php
// New Future Account Transfer
$app->future->transfer($params);
// Get Future Account Transaction History List
$app->future->transferHistory($params);
// Borrow For Cross-Collateral
$app->future->borrow($params);
// Cross-Collateral Borrow History
$app->future->borrowHistory($params);
// Repay For Cross-Collateral
$app->future->repay($params);
// Cross-Collateral Repayment History
$app->future->repayHistory($params);
// Cross-Collateral Wallet - v1 & v2，default v1，the same below
$version = 'v1';
$app->future->wallet($version);
// Cross-Collateral Information - v1 & v2，default v1，the same below
$app->future->configs($params, $version);
// Calculate Rate After Adjust Cross-Collateral LTV - v1 & v2
$app->future->calcAdjustLevel($params, $version);
// Get Max Amount for Adjust Cross-Collateral LTV - v1 & v2
$app->future->calcMaxAdjustAmount($params, $version);
// Adjust Cross-Collateral LTV - v1 & v2
$app->future->adjustCollateral($params, $version);
// Adjust Cross-Collateral LTV History
$app->future->adjustCollateralHistory($params);
// Cross-Collateral Liquidation History
$app->future->liquidationHistory($params);
// Check Collateral Repay Limit-Check the maximum and minimum limit when repay with collateral
$app->future->collateralRepayLimit($params);
// Get Collateral Repay Quote
$app->future->getCollateralRepay($params);
// Repay with Collateral-Repay with collateral. Get quote before repay with collateral is mandatory, the quote will be valid within 25 seconds
$quoteId = '8a03da95f0ad4fdc8067e3b6cde72423';
$app->future->collateralRepay($quoteId);
// Collateral Repayment Result
$app->future->collateralRepayResult($quoteId);
// Cross-Collateral Interest History
$app->future->interestHistory($params);
```

8. Mining
```php
// Acquiring Algorithm
$app->pool->algoList();
// Acquiring CoinName
$app->pool->coinList();
// Request for Detail Miner List
$app->pool->workerDetail($params);
// Request for Miner List
$app->pool->workerList($params);
// Earnings List
$app->pool->paymentList($params);
// Extra Bonus List
$app->pool->paymentOther($params);
// Hashrate Resale Detail List
$app->pool->hashTransferConfigDetails($params);
// Hashrate Resale List
$app->pool->hashTransferConfigDetailsList($params);
// Hashrate Resale Detail
$app->pool->hashTransferProfitDetails($params);
// Hashrate Resale Request
$app->pool->hashTransferConfig($params);
// Cancel hashrate resale configuration
$app->pool->hashTransferConfigCancel($params);
// Statistic List
$app->pool->userStatus($params);
// Account List
$app->pool->userList($params);
```

### Huobi
```php
<?php

use EasyExchange\Factory;

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

1. Basic Information
```php
// Get system status
$app->basic->systemStatus();
// Get Market Status
$app->basic->marketStatus();
// Get all Supported Trading Symbol
$app->basic->exchangeInfo();
// Get all Supported Currencies
$app->basic->currencys();
// APIv2 - Currency & Chains
$app->basic->currencies();
// Get Current Timestamp
$app->basic->systemTime();
```

2. Account Information
```php
// Get all Accounts of the Current User
$app->user->accounts();
// Get Account Balance of a Specific Account
$account_id = 360218;
$app->user->balance($account_id);
// Get Asset Valuation
$params = []; // For specific values, see the corresponding api document, the same below
$app->user->assetValuation($params);
// Asset Transfer
$app->user->transfer($params);
// Get Account History
$app->user->history($params);
// Get Account Ledger
$app->user->ledger($params);
// Transfer Fund Between Spot Account and Future Contract Account
$app->user->futuresTransfer($params);
// Get Point Balance
$app->user->point($subUid = '');
// Point Transfer
$app->user->pointTransfer($params);
```

3. Market Data
```php
// Get Klines(Candles)
$params = [
    'symbol' => 'btcusdt',
    'period' => '5min',
];
$app->market->kline($params);
// Get Latest Aggregated Ticker
$app->market->aggTrades($symbol);
// Get Latest Tickers for All Pairs
$app->market->tickers();
// Get Market Depth
$app->market->depth($params);
// Get the Last Trade
$app->market->trades($symbol);
// Get the Most Recent Trades
$app->market->historicalTrades($symbol);
// Get the Last 24h Market Summary
$app->market->hr24($symbol);
// Get real time NAV
$app->market->etp($symbol);
```

4. Wallet
```php
// Query Deposit Address
$currency = 'btc';
$app->wallet->depositAddress($currency);
// Query Withdraw Quota
$app->wallet->withdrawQuota($currency);
// Query withdraw address
$params = [
    'currency' => 'xrp',
];
$app->wallet->withdrawAddress($params);
// Create a Withdraw Request
$app->wallet->withdraw($params);
// Cancel a Withdraw Request
$app->wallet->cancelWithdraw($params);
// Search for Existed Withdraws and Deposits
$app->wallet->depositHistory($params);
```

5. Trading
```php
// Place a New Order
$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
    'type' => 'buy-limit',
    'amount' => 0.001,
    'price' => 10000,
];
$app->trade->order($params);
// Place a Batch of Orders
$app->trade->batchOrders($params);
// Submit Cancel for an Order
$app->trade->cancelOrder('204533841408061');
// Submit Cancel for an Order (based on client order ID)
$client_order_id = 'a0001';
$app->trade->cancelClientOrder($client_order_id);
// Get All Open Orders
$params = [
    'account-id' => 360000,
    'symbol' => 'btcusdt',
//    'side' => 'both',
];
$app->trade->openOrders($params);
// Submit Cancel for Multiple Orders by Criteria
$app->trade->batchCancelOpenOrders($params);
// Submit Cancel for Multiple Orders by IDs
$order_ids = ['5983466', '5722939', '5721027'];
$app->trade->batchCancel($order_ids);
// Dead man’s switch
$timeout = 10;
$app->trade->cancelAllAfter($timeout);
// Get the Order Detail of an Order
$order_id = '59378';
$app->trade->get($order_id);
// Get the Order Detail of an Order (based on client order ID)
$order_client_id = 'a0001';
$app->trade->getClientOrder($order_client_id);
// Get the Match Result of an Order
$app->trade->matchResult($order_id);
// Search Past Orders
$app->trade->getOrders($params);
// Search Historical Orders within 48 Hours
$app->trade->hr48History($params);
// Search Match Results
$app->trade->matchResults($params);
// Get Current Fee Rate Applied to The User
$symbols = 'btcusdt,ethusdt,ltcusdt';
$app->trade->transactFeeRate($symbols);
```

6. Margin Loan（Cross/Isolated）
```php
// Repay Margin Loan（Cross/Isolated ）
$app->margin->repayment($params);
// Transfer Asset from Spot Trading Account to Isolated Margin Account（Isolated）.
$app->margin->transferIn($params);
// Transfer Asset from Isolated Margin Account to Spot Trading Account（Isolated）.
$app->margin->transferOut($params);
// Get Loan Interest Rate and Quota（Isolated）.
$app->margin->loanInfo($params);
// Request a Margin Loan（Isolated）.
$app->margin->orders($params);
// Repay Margin Loan（Isolated）.
$app->margin->repay($order_id, $amount);
// Search Past Margin Orders（Isolated）.
$app->margin->loanOrders($params);
// Get the Balance of the Margin Loan Account（Isolated）.
$app->margin->balance($symbol = '', $sub_uid = '');
// Transfer Asset from Spot Trading Account to Cross Margin Account（Cross）.
$app->margin->crossTransferIn($currency, $amount);
// Transfer Asset from Cross Margin Account to Spot Trading Account（Cross）.
$app->margin->crossTransferOut($currency, $amount);
// Get Loan Interest Rate and Quota（Cross）.
$app->margin->crossLoanInfo();
// Request a Margin Loan（Cross）.
$app->margin->crossOrders($currency, $amount);
// Repay Margin Loan（Cross）.
$app->margin->crossRepay($order_id, $amount);
// Search Past Margin Orders（Cross）.
$app->margin->crossLoanOrders($params);
// Get the Balance of the Margin Loan Account（Cross）.
$app->margin->crossBalance($sub_uid = '');
// Repayment Record Reference（Cross）.
$app->margin->getRepayment($params);
```

7. Conditional Order
```php
// Place a conditional order
$app->algo->order($params);
// Cancel conditional orders (before triggering).
$app->algo->cancelOrder($clientOrderIds);
// Query open conditional orders (before triggering).
$app->algo->openOrders($params);
// Query conditional order history.
$app->algo->orderHistory($params);
// Query a specific conditional order.
$app->algo->specific($clientOrderId);
```

8. Margin Loan（C2C）
```php
// Place a lending/borrowing offer
$app->c2c->order($params);
// Cancel a lending/borrowing offer.
$app->c2c->cancelOrder($params);
// Cancel all lending/borrowing offers.
$app->c2c->cancelAll($params);
// Query lending/borrow offers.
$app->c2c->getOrders($params);
// Query a lending/borrowing offer.
$app->c2c->get($offerId);
// Query lending/borrowing transactions.
$app->c2c->transactions($params);
// Repay a borrowing offer.
$app->c2c->repayment($params);
// Query C2C repayments.
$app->c2c->getRepayment($params);
// Transfer asset.
$app->c2c->transfer($params);
// Query C2C account balance.
$app->c2c->balance($accountId, $currency = '');
```

### OKEX Version V5
```php
<?php

use EasyExchange\Factory;

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
