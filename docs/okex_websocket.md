## OKEx Websocket

#### Introduction

See [binance websocket documentation](binance_websocket.md) for details

### Usage

1. Example

```php
<?php

use EasyExchange\Factory;
use Workerman\Timer;

class OkexHandle extends \EasyExchange\Okex\Websocket\Handle
{
    public function onMessage($connection, $params, $data)
    {
        // Execute the built-in login method
        parent::onMessage($connection, $params, $data);

        // your logic ....
        echo $data.PHP_EOL;
        $time_interval = 20;
        if ('pong' != $data) {
            $connection->timer_id = Timer::add($time_interval, function () use ($connection) {
                $connection->send('ping');
            });
        } else {
            // delete timer
            Timer::del($connection->timer_id);
        }
    }
}

class Test
{
    public function ws()
    {
        $config = [
            'okex' => [
                'response_type' => 'array',
                'base_uri' => 'https://www.okex.com',
                'ws_base_uri' => 'ws://ws.okex.com:8443',
                'app_key' => 'your app key',
                'secret' => 'your secret',
                'passphrase' => 'your passphrase',
                'x-simulated-trading' => 1,
            ],
        ];
        $app = Factory::okex($config['okex']);
        $params = [
            'op' => 'subscribe',
            'args' => [
//                [
//                    'channel' => 'instruments',
//                    'instType' => 'FUTURES', // Required
//                    'instType' => 'SPOT', // Required
//                ],
                [
                    'channel' => 'tickers',
                    'instId' => 'BTT-BTC', // Required
                ],
            ],
        ];
        $params = [
            'auth' => true, // private channel
            'op' => 'subscribe',
            'args' => [
                [
                    'channel' => 'account',
                    'ccy' => 'BTC',
                ],
                [
                    'channel' => 'positions',
                    'instType' => 'ANY',
                ],
            ],
        ];
        $app->websocket->subscribe($params, new OkexHandle());
    }
}

$tc = new Test();
$tc->ws();
```

2. Start script monitoring:`php test.php start`
