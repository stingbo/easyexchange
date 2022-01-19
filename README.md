## PHP Easy Exchange Api
- Easy use digital currency exchange SDK, include `Binance`, `OKEx`, `Huobi`, `Gate`, `Coinbase` etc
- If you don’t have what you want, please let me know, and I will fulfill your wish :smile:
- Pull requests are welcome.
- [中文文档](README_CN.md)

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

## Websocket

| platform | support |
| :---: | :---: |
| [Binance](docs/binance_websocket.md) | :heavy_check_mark: |
| [Huobi](docs/huobi_websocket.md) | :heavy_check_mark: |
| [OKEx](docs/okex_websocket.md) | :heavy_check_mark: |
| [Gate](docs/gate_websocket.md) | :heavy_check_mark: |
| [Coinbase](docs/coinbase_websocket.md) | :heavy_check_mark: |

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
        'proxy' => [
            'http' => 'socks5h://127.0.0.1:1080', // Use this proxy with "http"
            'https' => 'socks5h://127.0.0.1:1080', // Use this proxy with "https"
            'no' => ['.mit.edu', 'foo.com'],   // Don't use a proxy with these
        ],
        'websocket' => [
            'base_uri' => 'ws://stream.binance.com:9443',
            'listen_ip' => '127.0.0.1', // listen ip
            'listen_port' => 2207, // listen port
            'heartbeat_time' => 20, // Heartbeat detection time, seconds
            'timer_time' => 3, // Scheduled task time，seconds
            'max_size' => 100, // Data retention，1～1000，Data is stored by channel name
            'data_time' => 1, // Time interval for getting data，seconds
            'debug' => true,
        ],
        'log' => [
            'level' => 'debug',
            'file'  => '/tmp/exchange.log',
        ],
        // ...
    ],
];

$app = Factory::binance($config['binance']);
```

<details>
    <summary> 1. Basic Information </summary>

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
</details>

<details>
<summary>2. Account Information</summary>

```php
// Get BNB Burn Status
$app->user->getBnbBurnStatus();
// Toggle BNB Burn On Spot Trade And Margin Interest
$params = []; // For specific values, see the corresponding api document, the same below
$app->user->bnbBurn($params);
```
</details>

<details>
<summary>3. Market Data</summary>

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
</details>

<details>
<summary>4. Wallet</summary>

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
// DustLog(SAPI)
$app->market->assetDribblet();
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
// Trade Fee(SAPI)
$app->market->assetTradeFee();
// User Universal Transfer
$app->market->transfer($params);
// Query User Universal Transfer History
$app->market->transferHistory($params);
```
</details>

<details>
<summary>5. Spot Trade</summary>

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
</details>

<details>
<summary>6. Cross Margin Account Transfer</summary>

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
$symbols = 'BTCUSDT,BNBUSDT,ADAUSDT';
$app->margin->isolatedAccount($symbols);
// Query Isolated Margin Symbol
$app->margin->isolatedPair($symbol);
// Get All Isolated Margin Symbol
$app->margin->isolatedAllPairs();
// Query Margin Interest Rate History
$app->margin->interestRateHistory($params);
```
</details>

<details>
<summary>7. Futures</summary>

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
</details>

<details>
<summary>8. Mining</summary>

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
</details>

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
        'proxy' => [
            'http' => 'socks5h://127.0.0.1:1080', // Use this proxy with "http"
            'https' => 'socks5h://127.0.0.1:1080', // Use this proxy with "https"
            'no' => ['.mit.edu', 'foo.com'],   // Don't use a proxy with these
        ],
        'websocket' => [
            'base_uri' => [
                [
                    'url' => 'ws://api.huobi.pro/ws',
                    'type' => 'public',
                ],
                [
                    'url' => 'ws://api.huobi.pro/ws/v2',
                    'type' => 'private',
                ]
            ],
            'listen_ip' => '127.0.0.1', // listen ip
            'listen_port' => 2207, // listen port
            'heartbeat_time' => 20, // Heartbeat detection time, seconds
            'timer_time' => 3, // Scheduled task time，seconds
            'max_size' => 100, // Data retention，1～1000，Data is stored by channel name
            'data_time' => 1, // Time interval for getting data，seconds
            'debug' => true,
        ],
        'log' => [
            'level' => 'debug',
            'file'  => '/tmp/exchange.log',
        ],
        // ...
    ],
];

$app = Factory::houbi($config['houbi']);
```

<details>
<summary>1. Basic Information</summary>

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
</details>

<details>
<summary>2. Account Information</summary>

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
</details>

<details>
<summary>3. Market Data</summary>

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
</details>

<details>
<summary>4. Wallet</summary>

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
</details>

<details>
<summary>5. Trading</summary>

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
</details>

<details>
<summary>6. Margin Loan（Cross/Isolated）</summary>

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
</details>

<details>
<summary>7. Conditional Order</summary>

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
</details>

<details>
<summary>8. Margin Loan（C2C）</summary>

```php
// Place a lending/borrowing offer
$app->c2c->order($params);
// Cancel a lending/borrowing offer.
$offerId = 14411;
$app->c2c->cancelOrder($offerId);
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
</details>

### OKEx Version V5
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
        'proxy' => [
            'http' => 'socks5h://127.0.0.1:1080', // Use this proxy with "http"
            'https' => 'socks5h://127.0.0.1:1080', // Use this proxy with "https"
            'no' => ['.mit.edu', 'foo.com'],   // Don't use a proxy with these
        ],
        'websocket' => [
            'base_uri' => [
                [
                    'url' => 'ws://ws.okex.com:8443/ws/v5/public',
                    'type' => 'public',
                ],
                [
                    'url' => 'ws://ws.okex.com:8443/ws/v5/private',
                    'type' => 'private',
                ]
            ],
            'listen_ip' => '127.0.0.1', // listen ip
            'listen_port' => 2207, // listen port
            'heartbeat_time' => 20, // Heartbeat detection time, seconds
            'timer_time' => 3, // Scheduled task time，seconds
            'max_size' => 100, // Data retention，1～1000，Data is stored by channel name
            'data_time' => 1, // Time interval for getting data，seconds
            'debug' => true,
        ],
        'log' => [
            'level' => 'debug',
            'file'  => '/tmp/exchange.log',
        ],
    ],
];

$app = Factory::okex($config['okex']);
```

<details>
<summary>1. Basic Information</summary>

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
</details>

<details>
<summary>2. Account Information</summary>

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
</details>

<details>
<summary>3. Market Data</summary>

```php
// Get Tickers - Retrieve the latest price snapshot, best bid/ask price, and trading volume in the last 24 hours
$app->market->tickers($instType, $uly = '');
// Get Ticker
$app->market->ticker($instId);
// Get Index Tickers
$app->market->indexTickers($quoteCcy = '', $instId = '');
// Get Order Book
$instId = 'BTC-USD-SWAP';
$sz = 1;
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
// Get exchange rate - This interface provides the average exchange rate data for 2 weeks
$app->market->exchangeRate();
```
</details>

<details>
<summary>4. Funding</summary>

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
</details>

<details>
<summary>5. Trade</summary>

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
</details>

<details>
<summary>6. Conditional Order(Algo Order)</summary>

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
</details>

### Gate Version V4

```php
<?php

use EasyExchange\Factory;

$config = [
    'gate' => [
        'response_type' => 'array',
        'base_uri' => 'https://api.gateio.ws',
        'app_key' => 'your app key',
        'secret' => 'your secret',
        'proxy' => [
            'http' => 'socks5h://127.0.0.1:1080', // Use this proxy with "http"
            'https' => 'socks5h://127.0.0.1:1080', // Use this proxy with "https"
            'no' => ['.mit.edu', 'foo.com'],   // Don't use a proxy with these
        ],
        'websocket' => [
            'base_uri' => 'ws://api.gateio.ws',
            'listen_ip' => '127.0.0.1', // listen ip
            'listen_port' => 2207, // listen port
            'heartbeat_time' => 20, // Heartbeat detection time, seconds
            'timer_time' => 3, // Scheduled task time，seconds
            'max_size' => 100, // Data retention，1～1000，Data is stored by channel name
            'data_time' => 1, // Time interval for getting data，seconds
            'debug' => true,
        ],
        'log' => [
            'level' => 'debug',
            'file'  => '/tmp/exchange.log',
        ],
    ],
];

$app = Factory::gate($config['gate']);
```

<details>
<summary>1. Wallet</summary>

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
</details>

<details>
<summary>2. Spot Trade</summary>

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
// List spot accounts.
$app->spot->accounts($currency);
// Create an order.
$params = [
    'currency_pair' => 'ETH_USDT',
    'side' => 'buy',
    'amount' => '0.1',
    'price' => '10',
];
$app->spot->order($params);
// Create a batch of orders.
$app->spot->batchOrders($params);
// List all open orders.
$app->spot->openOrders($page = '', $limit = '');
// List orders.
$app->spot->orders($params);
// Cancel all open orders in specified currency pair.
$app->spot->cancelOrders($params);
// Cancel a batch of orders with an ID list.
$app->spot->cancelBatchOrders($params);
// Get a single order
$app->spot->get($order_id, $currency_pair);
// Cancel a single order.
$app->spot->cancelOrder($order_id, $currency_pair);
// List personal trading history.
$app->spot->myTrades($params);
// Create a price-triggered order.
$app->spot->priceOrder($params);
// Retrieve running auto order list.
$app->spot->priceOrders($params);
// Cancel all open orders.
$app->spot->cancelPriceOrders($market = '', $account = '');
// Get a single order.
$app->spot->getPriceOrder($order_id);
// Cancel a single order.
$app->spot->cancelPriceOrder($order_id);
```
</details>

<details>
<summary>3. Margin</summary>

```php
// List all supported currency pairs supported in margin trading.
$app->margin->currencyPairs();
// Query one single margin currency pair.
$app->margin->currencyPair($currency_pair);
// Order book of lending loans.
$app->margin->depth($currency);
// Margin account list.
$app->margin->accounts($currency_pair = '');
// List margin account balance change history.
$app->margin->accountHistory($params);
// Funding account list.
$app->margin->fundingAccounts($currency = '');
// Lend or borrow.
$app->margin->loan($params);
// List all loans.
$app->margin->loanHistory($params);
// Merge multiple lending loans.
$app->margin->mergeLoan($currency, $ids);
// Retrieve one single loan detail.
$app->margin->get($loan_id, $side);
// Modify a loan.
$app->margin->modifyLoan($loan_id, $params);
// Cancel lending loan.
$app->margin->cancelLoan($loan_id, $currency);
// Repay a loan.
$app->margin->repayment($loan_id, $params);
// List loan repayment records.
$app->margin->getRepayment($loan_id);
// List repayment records of specified loan.
$app->margin->loanRecords($params);
// Get one single loan record.
$app->margin->loanRecord($loan_id, $loan_record_id);
// Modify a loan record.
$app->margin->modifyLoanRecord($loan_record_id, $params);
// Update user's auto repayment setting.
$app->margin->autoRepay($status);
// Retrieve user auto repayment setting.
$app->margin->getAutoRepayStatus();
```
</details>

<details>
<summary>4. Future</summary>

```php
// List all futures contracts.
$app->future->contracts($settle);
// Get a single contract.
$app->future->contract($settle, $contract);
// Futures order book.
$app->future->depth($settle, $params);
// Futures trading history.
$app->future->trades($settle, $params);
// Get futures candlesticks.
$app->future->kline($settle, $params);
// List futures tickers.
$app->future->tickers($settle, $contract);
// Funding rate history.
$app->future->fundingRateHistory($settle, $params);
// Futures insurance balance history.
$app->future->insuranceHistory($settle, $limit = '');
// Futures stats.
$app->future->contractStats($settle, $params);
// Retrieve liquidation history.
$app->future->liquidationOrders($settle, $params = []);
// Query futures account.
$app->future->accounts($settle);
// Query account book.
$app->future->accountHistory($settle, $params = []);
// List all positions of a user.
$app->future->positions($settle);
// Get single position.
$app->future->position($settle, $contract);
// Update position margin.
$app->future->modifyPositionMargin($settle, $contract, $change);
// Update position leverage.
$app->future->modifyPositionLeverage($settle, $contract, $leverage);
// Update position risk limit.
$app->future->modifyPositionRiskLimit($settle, $contract, $risk_limit);
// Enable or disable dual mode.
$app->future->setDualMode($settle, $dual_mode);
// Retrieve position detail in dual mode.
$app->future->dualCompPosition($settle, $contract);
// Update position margin in dual mode.
$app->future->modifyDualCompPositionMargin($settle, $contract, $change);
// Update position leverage in dual mode.
$app->future->modifyDualCompPositionLeverage($settle, $contract, $leverage);
// Update position risk limit in dual mode.
$app->future->modifyDualCompPositionRiskLimit($settle, $contract, $risk_limit);
// Create a futures order.
$app->future->order($settle, $params);
// List futures orders.
$app->future->orders($settle, $params);
// Cancel all open orders matched.
$app->future->cancelOrders($settle, $params);
// Cancel a single order.
$app->future->cancelOrder($settle, $order_id);
// Get a single order.
$app->future->get($settle, $order_id);
// List personal trading history.
$app->future->myTrades($settle, $params);
// List position close history.
$app->future->positionClose($settle, $params);
// List liquidation history.
$app->future->forceLiquidationRec($settle, $params);
// Create a price-triggered order.
$app->future->priceOrder($settle, $params);
// List all auto orders.
$app->future->priceOrders($settle, $params);
// Cancel all open orders.
$app->future->cancelPriceOrders($settle, $contract);
// Get a single order.
$app->future->getPriceOrder($settle, $order_id);
// Cancel a single order.
$app->future->cancelPriceOrder($settle, $order_id);
```
</details>

<details>
<summary>5. Delivery</summary>

```php
// List all futures contracts.
$app->delivery->contracts($settle);
// Get a single contract.
$app->delivery->contract($settle, $contract);
// Futures order book.
$app->delivery->depth($settle, $params);
// Futures trading history.
$app->delivery->trades($settle, $params);
// Get futures candlesticks.
$app->delivery->kline($settle, $params);
// List futures tickers.
$app->delivery->tickers($settle, $contract);
// Futures insurance balance history.
$app->delivery->insuranceHistory($settle, $limit = '');
// Query futures account.
$app->delivery->accounts($settle);
// Query account book.
$app->delivery->accountHistory($settle, $params = []);
// List all positions of a user.
$app->delivery->positions($settle);
// Get single position.
$app->delivery->position($settle, $contract);
// Update position margin.
$app->delivery->modifyPositionMargin($settle, $contract, $change);
// Update position leverage.
$app->delivery->modifyPositionLeverage($settle, $contract, $leverage);
// Update position risk limit.
$app->delivery->modifyPositionRiskLimit($settle, $contract, $risk_limit);
// Create a futures order.
$app->delivery->order($settle, $params);
// List futures orders.
$app->delivery->orders($settle, $params);
// Cancel all open orders matched.
$app->delivery->cancelOrders($settle, $params);
// Cancel a single order.
$app->delivery->cancelOrder($settle, $order_id);
// Get a single order.
$app->delivery->get($settle, $order_id);
// List personal trading history.
$app->delivery->myTrades($settle, $params);
// List position close history.
$app->delivery->positionClose($settle, $params);
// List liquidation history.
$app->delivery->forceLiquidationRec($settle, $params);
// List settlement history.
$app->delivery->settlements($settle, $params = []);
// Create a price-triggered order.
$app->delivery->priceOrder($settle, $params);
// List all auto orders.
$app->delivery->priceOrders($settle, $params);
// Cancel all open orders.
$app->delivery->cancelPriceOrders($settle, $contract);
// Get a single order.
$app->delivery->getPriceOrder($settle, $order_id);
// Cancel a single order.
$app->delivery->cancelPriceOrder($settle, $order_id);
```
</details>

### Coinbase

```php
<?php

use EasyExchange\Factory;

$config = [
    'coinbase' => [
        'response_type' => 'array',
        'base_uri' => 'https://api.pro.coinbase.com',
        'app_key' => 'your app key',
        'secret' => 'your secret',
        'passphrase' => 'your passphrase',
        'proxy' => [
            'http' => 'socks5h://127.0.0.1:1080', // Use this proxy with "http"
            'https' => 'socks5h://127.0.0.1:1080', // Use this proxy with "https"
            'no' => ['.mit.edu', 'foo.com'],   // Don't use a proxy with these
        ],
        'websocket' => [
            'base_uri' => 'ws://ws-feed.pro.coinbase.com',
            'listen_ip' => '127.0.0.1', // listen ip
            'listen_port' => 2207, // listen port
            'heartbeat_time' => 20, // Heartbeat detection time, seconds
            'timer_time' => 3, // Scheduled task time，seconds
            'max_size' => 100, // Data retention，1～1000，Data is stored by channel name
            'data_time' => 1, // Time interval for getting data，seconds
            'debug' => true,
        ],
        'log' => [
            'level' => 'debug',
            'file'  => '/tmp/exchange.log',
        ],
    ],
];

$app = Factory::coinbase($config['coinbase']);
```

<details>
<summary>1. Account Information</summary>

```php
// List Accounts - Get a list of trading accounts from the profile of the API key.
$app->user->accounts();
// Get an Account - Information for a single account.
$app->user->account($account_id);
// Get Account History - List account activity of the API key's profile.
$app->user->history($account_id, $params = []);
// Get Holds - List holds of an account that belong to the same profile as the API key.
$app->user->holds($account_id, $params = []);
// List Accounts - Get a list of your coinbase accounts.
$app->user->coinbaseAccounts();
// fees - Get Current Fees.
$app->user->fees();
// List Profiles.
$app->user->profiles();
// Get a Profile.
$app->user->profile($profile_id);
// Create profile transfer - Transfer funds from API key's profile to another user owned profile.
$app->user->transfer($params);
```
</details>

<details>
<summary>2. Market Data</summary>

```php
// Get Products - Get a list of available currency pairs for trading.
$app->market->products();
// Get Single Product - Get market data for a specific currency pair.
$product_id = 'BTC-USD';
$app->market->product($product_id);
// Get Product Order Book - Get a list of open orders for a product. The amount of detail shown can be customized with the level parameter.
$level = 2;
$app->market->depth($product_id, $level);
// Get Product Ticker - Snapshot information about the last trade (tick), best bid/ask and 24h volume.
$app->market->tickers($product_id);
// Get Trades - List the latest trades for a product.
$params = [ 'before' => 10, 'limit' => 5];
$app->market->trades($product_id, $params);
// Get Historic Rates - Historic rates for a product. Rates are returned in grouped buckets based on requested granularity.
$app->market->kline($product_id);
// Get 24hr Stats - Get 24 hr stats for the product. volume is in base currency units. open, high, low are in quote currency units.
$app->market->hr24($product_id);
// Get currencies - List known currencies.
$app->market->currencies();
// Get a currency - List the currency for specified id.
$id = 'BTC';
$app->market->currency($id);
// Get the API server time.
$app->market->time();
```
</details>

<details>
<summary>3. Wallet</summary>

```php
// Get Current Exchange Limits.
$app->wallet->exchangeLimits();
// List Deposits Or List Withdrawals.
$app->wallet->transferHistory($params);
// Single Deposit Or Single Withdrawal.
$app->wallet->getTransfer($transfer_id);
// List Payment Methods.
$app->wallet->paymentMethods();
// Payment method - Deposit funds from a payment method.
$app->wallet->depositPaymentMethod($params);
// Payment method - Withdraw funds to a payment method.
$app->wallet->withdrawalPaymentMethod($params);
// Coinbase - Deposit funds from a coinbase account.
$app->wallet->depositCoinbaseAccount($params);
// Coinbase - Withdraw funds to a coinbase account.
$app->wallet->withdrawalCoinbaseAccount($params);
// List Accounts - Get a list of your coinbase accounts.
$app->wallet->listAccounts();
// Generate a Crypto Deposit Address.
$app->wallet->generateDepositAddress($account_id);
// Withdraws funds to a crypto address.
$app->wallet->withdrawalCrypto($params);
// Fee Estimate - Gets the network fee estimate when sending to the given address.
$app->wallet->feeEstimate($currency, $crypto_address);
// Create Conversion - eg:Convert $10,000.00 to 10,000.00 USDC.
$app->wallet->conversion($params);
```
</details>

<details>
<summary>4. Trade</summary>

```php
// Place a New Order.
$params = [
    'size' => '0.01',
    'price' => '0.100',
    'side' => 'buy',
    'product_id' => 'BTC-USD',
];
$app->trade->order($params);
// Cancel an Order.
$app->trade->cancelOrder($id = '', $client_oid = '', $product_id = '');
// Cancel all.
$app->trade->cancelOrders($product_id = '');
// List Orders.
$app->trade->orders($params);
// Get an Order.
$app->trade->get($id = '', $client_oid = '');
// List Fills - Get a list of recent fills of the API key's profile.
$app->trade->fills($params);
```
</details>

<details>
<summary>5. Margin</summary>

```php
// Get margin profile information.
$app->margin->profileInformation($product_id);
// Get buying power or selling power.
$app->margin->buyingPower($product_id);
// Get withdrawal power.
$app->margin->withdrawalPower($currency);
// Get all withdrawal powers.
$app->margin->withdrawalPowers();
// Get exit plan.
$app->margin->exitPlan();
// List liquidation history.
$app->margin->liquidationHistory($after = '');
// Get position refresh amounts.
$app->margin->positionRefreshAmounts();
// Get margin status - Returns whether margin is currently enabled.
$app->margin->status();
```
</details>

## Donation Address：
| Coin | Address |
| :---: | :---: |
| DOGE | D5QXoFYTAzs756SnP4gqiEePtrb5oQZRrW |
| XRP | rEb8TK3gBgk5auZkwc6sHnwrGVJH8DuaLh // TAG:310515423 |
| BTC | 163guqWS4hcpPcfzaEUa1NypH3PLdEJ9TE |
| ETH | 0xab6b060592bce331a1bb4e649016173274a99cb0 |

## API Support
| contact us | detail |
| :---: | :---: |
| QQ Group | 871358160 |
| Email | lianbo.wan@gmail.com |
| Email | sting_bo@163.com |
