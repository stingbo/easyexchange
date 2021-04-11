## Websocket Market Streams

#### Introduction

* BinanceHandle must be an object that implements the `EasyExchange\Kernel\Websocket\Handle` interface

* This design is to make development more flexible and more convenient for users to customize their own logic

* Handle function definition:

    > 1. onConnect - Trigger when websocket connected

    > 2. onMessage - Trigger on websocket communication

    > 3. onError - Triggered when an error occurs on the connection

    > 4. onClose - Triggered when the server is disconnected

* Parameter definition:

    > 1. connection - Workerman client connection object

    > 2. params - Client request parameters

    > 3. data - Server return data

    > 4. code - The server returns an error code

    > 5. message - The server returns an error message

### Usage

1. Example

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\Handle;

class BinanceHandle implements Handle
{
    public function onConnect($connection, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $data)
    {
        echo $data.PHP_EOL;
        // your logic ....
    }

    public function onError($connection, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection)
    {
        echo "connection closed\n";
    }
}

class Test
{
    public function ws()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://testnet.binance.vision',
                'ws_base_uri' => 'ws://stream.binance.com:9443',
                'app_key' => 'your app key',
                'secret' => 'your secret',
            ],
        ];
        $app = Factory::binance($config['binance']);
        $params = [
            'id' => 1,
            'params' => [
                "btcusdt@aggTrade",
                "btcusdt@depth"
            ],
        ];
        $app->websocket->subscribe($params, new BinanceHandle());
    }
}

$tc = new Test();
$tc->ws();
```

2. Start script monitoring:`php test.php start`
