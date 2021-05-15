## Coinbase Websocket 文档

#### 说明

见[币安 websocket 文档](binance_websocket_cn.md)

1. 启动本地服务，server.php 示例:

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Coinbase\Socket\Handle;

class Server
{
    public function ws()
    {
        $config = [
            'coinbase' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.pro.coinbase.com',
                'app_key' => 'your app key',
                'secret' => 'your secret',
                'websocket' => [
                    'base_uri' => 'ws://ws-feed.pro.coinbase.com',
                    'listen_ip' => '0.0.0.0', // 监听的本机ip地址
                    'listen_port' => 2207, // 监听的端口
                    'heartbeat_time' => 20, // 心跳检测时间，单位秒
                    'timer_time' => 3, // 定时任务间隔时间，秒
                    'max_size' => 100, // 数据保留量，1～1000，数据按频道名称存储
                    'data_time' => 1, // 获取数据的时间间隔，秒
                    'debug' => true,
                ],
            ],
        ];
        $app = Factory::coinbase($config['coinbase']);
        $app->websocket->server([], new Handle());
    }
}

$tc = new Server();
$tc->ws();
```

2. 启动脚本监听:`php server.php start`

3. 本地客户端示例
```php
<?php

use EasyExchange\Factory;

class Test
{
    public function t()
    {
        $config = [
            'coinbase' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.pro.coinbase.com',
                'app_key' => 'your app key',
                'secret' => 'your secret',
                'websocket' => [
                    'base_uri' => 'ws://ws-feed.pro.coinbase.com',
                    'listen_ip' => '0.0.0.0', // 监听的本机ip地址
                    'listen_port' => 2207, // 监听的端口
                    'heartbeat_time' => 20, // 心跳检测时间，单位秒
                    'timer_time' => 3, // 定时任务间隔时间，秒
                    'max_size' => 100, // 数据保留量，1～1000，数据按频道名称存储
                    'data_time' => 1, // 获取数据的时间间隔，秒
                    'debug' => true,
                ],
            ],
        ];
        $app = Factory::coinbase($config['coinbase']);
        $params = [
            'type' => 'subscribe',
            'product_ids' => [
                'ETH-USD',
                'ETH-EUR'
            ],
            'channels' => [
                'level2',
                'heartbeat',
                [
                    'name' => 'ticker',
                    'product_ids' => [
                        'ETH-BTC',
                        'ETH-USD'
                    ],
                ],
            ],
        ];

        // 订阅
        $app->websocket->subscribe($params);

        $params = [
            'type' => 'unsubscribe',
            'product_ids' => [
                'ETH-USD',
                'ETH-EUR'
            ],
            'channels' => [
                'level2',
                'heartbeat',
                [
                    'name' => 'ticker',
                    'product_ids' => [
                        'ETH-BTC',
                        'ETH-USD'
                    ],
                ],
            ],
        ];
        // 取消订阅
        $app->websocket->unsubscribe($params);

        // 获取已订阅的频道
        $channels = $app->websocket->getSubChannel();
        print_r($channels);

        // 根据频道获取数据，不传频道默认获取所有已订阅频道的数据
        $channels = ['l2update', 'ticker'];
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
