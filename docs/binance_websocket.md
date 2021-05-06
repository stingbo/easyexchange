## Binance Websocket Documentation

#### Introduction

* BinanceHandle must implement the `EasyExchange\Kernel\Websocket\Handle` interface
Or inherit the system built-in `EasyExchange\Binance\Websocket\Handle` object

* This design is to make development more flexible and more convenient for users to customize their own logic

* Handle function definition:

    > 1. getConnection - Get the connection object

    > 2. onConnect - Trigger when websocket connected

    > 4. onMessage - Trigger on websocket communication

    > 4. onError - Triggered when an error occurs on the connection

    > 5. onClose - Triggered when the server is disconnected

* Parameter definition:

    > 1. config Configuration parameter

    > 2. connection - Workerman client connection object

    > 3. params - Client request parameters

    > 4. data - Server return data

    > 5. code - The server returns an error code

    > 6. message - The server returns an error message

### Usage

1. Example

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Binance\Socket\Handle;
use Workerman\Connection\AsyncTcpConnection;

class BinanceHandle extends Handle
{
    public function getConnection($config, $params)
    {
        $ws_base_uri = $config['ws_base_uri'].'/ws';

        $connection = new AsyncTcpConnection($ws_base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $params, $data)
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
