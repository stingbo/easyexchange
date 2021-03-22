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

1. Basic Information
```php
$params = [
    'instType' => 'SPOT',
];
// Get Instruments
$app->basic->exchangeInfo($params);
// Get Delivery/Exercise History
$app->basic->deliveryExerciseHistory($params);
// Get Open Interest
$app->basic->openInterest($params);
// Get Funding Rate
$app->basic->fundingRate($instId);
// Get Funding Rate History
$app->basic->fundingRateHistory($params);
// Get Limit Price
$app->basic->priceLimit($instId);
// Get Option Market Data
$app->basic->optSummary($uly, $expTime = '');
// Get Estimated Delivery/Excercise Price
$app->basic->estimatedPrice($instId);
// Get Discount Rate And Interest-Free Quota
$app->basic->discountRateInterestFreeQuota($ccy = '');
// Get System Time
$app->basic->systemTime();
// Get Liquidation Orders
$app->basic->liquidationOrders($params);
// Get Mark Price
$app->basic->markPrice($params);
```

2. Account Information
```php
// Get Balance
$app->user->balance($ccy = '');
// Get Positions
$app->user->positions($params);
// Get Bills Details (last 7 days)
$app->user->bills($params);
// Get Bills Details (last 3 months)
$app->user->billsArchive($params);
// Get Account Configuration
$app->user->config();
// Set Position mode
$app->user->setPositionMode($posMode);
// Set Leverage
$app->user->setLeverage($params);
// Get maximum buy/sell amount or open amount
$app->user->maxSize($params);
// Get Maximum Available Tradable Amount
$app->user->maxAvailSize($params);
// Increase/Decrease margin
$app->user->marginBalance($params);
// Get Leverage
$app->user->leverageInfo($instId, $mgnMode);
// Get the maximum loan of instrument
$app->user->maxLoan($params);
// Get Fee Rates
$app->user->tradeFee($params);
// Get interest-accrued
$app->user->interestAccrued($params);
// Set Greeks (PA/BS)
$app->user->setGreeks($greeksType);
// Get Maximum Withdrawals
$app->user->maxWithdrawal($ccy = '');
```

3. Market Data
```php
// Get Tickers - Retrieve the latest price snapshot, best bid/ask price, and trading volume in the last 24 hours
$app->market->tickers($instType, $uly = '');
// Get Ticker
$app->market->ticker($instId);
// Get Index Tickers
$app->market->indexTickers($quoteCcy = '', $instId = '');
// Get Order Book
$instId = 'BTC-USD-SWAP';
$sz = 1
$app->market->depth($instId, $sz);
// Get Candlesticks
$app->market->kline($params);
// Get Candlesticks History（top currencies only）
$app->market->klineHistory($params);
// Get Index Candlesticks
$app->market->indexKline($params);
// Get Mark Price Candlesticks
$app->market->markPriceKline($params);
// Get Trades
$app->market->trades($instId, $limit = 100);
```

4. Funding
```php
// Get Deposit Address
$app->wallet->depositAddress($ccy);
// Get Balance.
$app->wallet->balance($ccy = '');
// Funds Transfer.
$app->wallet->transfer($params);
// Withdrawal.
$app->wallet->withdrawal($params);
// Get Deposit History.
$app->wallet->depositHistory($params = []);
// Get Withdrawal History.
$app->wallet->withdrawalHistory($params = []);
// Get Currencies.
$app->wallet->currencies();
// PiggyBank Purchase/Redemption.
$app->wallet->purchaseRedempt($params);
// Asset Bills Details.
$app->wallet->bills($params);
```

5. Trade
```php
$params = [
    'instId' => 'BTC-USD-190927-5000-C',
    'tdMode' => 'cash',
    'side' => 'buy',
    'ordType' => 'limit', // limit
    'sz' => '0.0001', // Quantity to buy or sell
    'px' => '1000', // Order price. Only applicable to limit order
];
// Place Order
$app->trade->order($params);
// Place Multiple Orders.
$app->trade->batchOrders($params);
// Cancel Order.
$app->trade->cancelOrder($params);
// Cancel Multiple Orders.
$app->trade->cancelBatchOrders($params);
// Amend Order - Amend an incomplete order.
$app->trade->amendOrder($params);
// Amend Multiple Orders.
$app->trade->amendBatchOrders($params);
// Close Positions.
$app->trade->closePosition($params);
$params = [
    'instId' => 'BTC-USD-190927-5000-C',
    'ordId' => '2510789768709120',
];
// Get Order Details
$app->trade->get($params);
// Get Order List.
$app->trade->openOrders($params);
// Get Order History (last 7 days）.
$app->trade->orderHistory($params);
// Get Order History (last 3 months).
$app->trade->orderHistoryArchive($params);
// Get Transaction Details.
$app->trade->fills($params);
```

6. Conditional Order(Algo Order)
```php
// Place Algo Order
$app->algo->order($params);
// Cancel Algo Order.
$app->algo->cancelOrder($params);
// Get Algo Order List.
$app->algo->openOrders($params);
// Get Algo Order History.
$app->algo->orderHistory($params);
```

### Gate Version V4

```php
<?php

use EasyExchange\Factory;

$config = [
    'gate' => [
        'base_uri' => 'https://api.gateio.ws',
        'app_key' => 'your app key',
        'secret' => 'your secret',
    ],
];

$app = Factory::gate($config['gate']);
```

1. Wallet
```php
// Generate currency deposit address.
$currency = 'USDT';
$app->wallet->depositAddress($currency);
// Retrieve withdrawal records.
$params = [];
$app->wallet->withdrawHistory($params);
// Retrieve deposit records.
$app->wallet->depositHistory($params);
// Transfer between trading accounts.
$app->wallet->transfer($params);
// Transfer between main and sub accounts.
$app->wallet->subAccountTransfer($params);
// Transfer records between main and sub accounts.
$app->wallet->subAccountTransferHistory($params);
// Retrieve withdrawal status.
$app->wallet->withdrawStatus($currency);
// Retrieve sub account balances.
$app->wallet->subAccountBalance($sub_uid = '');
// Retrieve personal trading fee.
$app->wallet->fee();
```

2. Spot Trade
```php
// List all currencies' detail.
$app->spot->currencies();
// Get detail of one particular currency.
$currency = 'GT';
$app->spot->currency($currency);
// List all currency pairs supported.
$app->spot->currencyPairs();
// Get detail of one single order.
$currency_pair = 'ETH_USDT';
$app->spot->currencyPair($currency_pair);
// Retrieve ticker information.
$app->spot->tickers($currency_pair);
// Retrieve order book.
$params = [
    'currency_pair' => 'ETH_USDT',
];
$app->spot->depth($params);
// Retrieve market trades.
$app->spot->trades($params);
// Market candlesticks.
$app->spot->kline($params);
// Create an order.
$params = [
    'currency_pair' => 'ETH_USDT',
    'side' => 'buy',
    'amount' => '0.1',
    'price' => '10',
];
$app->spot->order($params);
```
