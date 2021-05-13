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

    > 7. client Workerman GlobalData\Client

### Usage

1. Start the local service, server.php example:

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

    public function onConnect($connection, $client, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $client, $params, $data)
    {
        echo $data.PHP_EOL;
        // your logic ....
    }

    public function onError($connection, $client, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed\n";
    }
}

class Server
{
    public function ws()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://testnet.binance.vision',
                'app_key' => 'your app key',
                'secret' => 'your secret',
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
            ],
        ];
        $app = Factory::binance($config['binance']);
        // You can customize your own Handle or use the one provided in the system \EasyExchange\Binance\Socket\Handle::class();
        $app->websocket->server([], new Handle());
    }
}

$tc = new Server();
$tc->ws();
```

2. Start script monitoring:`php server.php start`

3. Local client use example
```php
<?php

use EasyExchange\Factory;

class Test
{
    public function t()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://testnet.binance.vision',
                'app_key' => 'your app key',
                'secret' => 'your secret',
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
            ],
        ];
        $app = Factory::binance($config['binance']);

        $params = [
            'method' => 'SUBSCRIBE',
            'id' => 1,
            'params' => [
                "btcusdt@aggTrade",
                "btcusdt@depth"
            ],
        ];
        // subscribe
        $app->websocket->subscribe($params);

        $params = [
            'method' => 'UNSUBSCRIBE',
            'id' => 1,
            'params' => [
                "btcusdt@aggTrade",
                "btcusdt@depth"
            ],
        ];
        // unsubscribe
        $app->websocket->unsubscribe($params);

        // Get subscribed channels
        $channels = $app->websocket->getSubChannel();
        print_r($channels);

        // 1. Obtain data according to the channel, if the channel is not transmitted, the data of all subscribed channels is obtained by default
        $channels = ['aggTrade', 'trade'];
        $data = $app->websocket->getChannelData($channels);
        print_r($data);

        // 2. Use functions to process data
        $app->websocket->getChannelData($channels, function ($data) {
            print_r($data);
        });

        // 3. Use daemons and functions to process data
        $app->websocket->getChannelData($channels, function ($data) {
            print_r($data);
        }, true);
    }
}

$tc = new Test();
$tc->t();
```
