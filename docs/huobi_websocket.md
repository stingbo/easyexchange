## Huobi Websocket

#### Introduction

See [binance websocket documentation](binance_websocket.md) for details

### Usage

1. Start the local service, server.php example:

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Huobi\Socket\Handle;

class Server
{
    public function ws()
    {
        $config = [
            'huobi' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.huobi.pro',
                'app_key' => 'your app key',
                'secret' => 'your secret',
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
            ],
        ];
        $app = Factory::huobi($config['huobi']);
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
            'huobi' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.huobi.pro',
                'app_key' => 'your app key',
                'secret' => 'your secret',
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
            ],
        ];
        $app = Factory::huobi($config['huobi']);
        $params = [
//            'sub' => 'market.btcusdt.kline.1min',
            'sub' => 'market.btcusdt.trade.detail',
            'id' => '11234',
        ];

        // subscribe
        $app->websocket->subscribe($params);

        $params = [
            'unsub' => 'market.btcusdt.trade.detail',
            'id' => '11234',
        ];
        // unsubscribe
        $app->websocket->unsubscribe($params);

        // Get subscribed channels
        $channels = $app->websocket->getSubChannel();
        print_r($channels);

        // 1. Obtain data according to the channel, if the channel is not transmitted, the data of all subscribed channels is obtained by default
        $channels = ['market.btcusdt.trade.detail'];
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
