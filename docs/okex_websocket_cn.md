## 欧易 Websocket 文档

#### 说明

详见[币安 websocket 文档](binance_websocket_cn.md)

1. 启动本地服务，server.php 示例:

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Okex\Socket\Handle;

class Server
{
    public function ws()
    {
        $config = [
            'okex' => [
                'response_type' => 'array',
                'base_uri' => 'https://www.okex.com',
                'app_key' => 'your app key',
                'secret' => 'your secret',
                'passphrase' => 'your passphrase',
                'x-simulated-trading' => 1,
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
                    'listen_ip' => '127.0.0.1', // 监听的本机ip地址
                    'listen_port' => 2207, // 监听的端口
                    'heartbeat_time' => 20, // 心跳检测时间，单位秒
                    'timer_time' => 3, // 定时任务间隔时间，秒
                    'max_size' => 100, // 数据保留量，1～1000，数据按频道名称存储
                    'data_time' => 1, // 获取数据的时间间隔，秒
                    'debug' => true,
                ],
            ],
        ];
        $app = Factory::okex($config['okex']);
        $app->websocket->server([], new Handle());
    }
}

$tc = new Server();
$tc->ws();
```

2. 启动脚本:`php server.php start`

3. 本地客户端示例
```php
<?php

use EasyExchange\Factory;

class Test
{
    public function t()
    {
        $config = [
            'okex' => [
                'response_type' => 'array',
                'base_uri' => 'https://www.okex.com',
                'app_key' => 'your app key',
                'secret' => 'your secret',
                'passphrase' => 'your passphrase',
                'x-simulated-trading' => 1,
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
                    'listen_ip' => '127.0.0.1', // 监听的本机ip地址
                    'listen_port' => 2207, // 监听的端口
                    'heartbeat_time' => 20, // 心跳检测时间，单位秒
                    'timer_time' => 3, // 定时任务间隔时间，秒
                    'max_size' => 100, // 数据保留量，1～1000，数据按频道名称存储
                    'data_time' => 1, // 获取数据的时间间隔，秒
                    'debug' => true,
                ],
            ],
        ];
        $app = Factory::okex($config['okex']);
        $params = [
            'op' => 'subscribe',
            'args' => [
                [
                    'channel' => 'tickers',
//                    'instId' => 'BTC-USDT', // Required
                    'instId' => 'LTC-USDT', // Required
                ],
                [
                    'channel' => 'tickers',
                    'instId' => 'ETH-USDT', // Required
                ],
//                [
//                    'channel' => 'instruments',
//                    'instType' => 'SPOT', // Required
//                ],
                [
                    'channel' => 'account',
                    'ccy' => 'LTC', // Required
//                    'ccy' => 'BTC', // Required
                ],
                [
                    'channel' => 'account',
                    'ccy' => 'USDT', // Required
                ],
            ],
        ];

        // 订阅
        $app->websocket->subscribe($params);

        $params = [
            'op' => 'unsubscribe',
            'args' => [
                [
                    'channel' => 'tickers',
//                    'instId' => 'BTC-USDT', // Required
                    'instId' => 'LTC-USDT', // Required
                ],
                [
                    'channel' => 'tickers',
                    'instId' => 'ETH-USDT', // Required
                ],
//                [
//                    'channel' => 'instruments',
//                    'instType' => 'SPOT', // Required
//                ],
                [
                    'channel' => 'account',
                    'ccy' => 'LTC', // Required
//                    'ccy' => 'BTC', // Required
                ],
                [
                    'channel' => 'account',
                    'ccy' => 'USDT', // Required
                ],
            ],
        ];
        // 取消订阅
        $app->websocket->unsubscribe($params);

        // 获取已订阅的频道
        $channels = $app->websocket->getSubChannel();
        print_r($channels);

        // 根据频道获取数据，不传频道默认获取所有已订阅频道的数据
        $channels = ['account', 'tickers'];
        $data = $app->websocket->getChannelData($channels);
        print_r($data);

        // 使用函数处理数据
        $app->websocket->getChannelData($channels, function ($data) {
            print_r($data);
        });

        // 使用守护进程和函数处理数据
        $app->websocket->getChannelData($channels, function ($data) {
            print_r($data);
        }, true);
    }
}

$tc = new Test();
$tc->t();
```
