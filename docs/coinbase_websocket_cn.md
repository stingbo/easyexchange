## CoinBase Websocket 文档

#### 说明

> DataTest 必须是实现了 EasyExchange\Kernel\Websocket\DataHandle 接口的对象

> DataHandle 里的 handle 方法接收两个参数，一个是 workerman 的 connection 客户端连接对象，一个是服务端返回的数据

1. 示例
```php
<?php

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\DataHandle;

class DataTest implements DataHandle
{
    public function handle($connection, $data)
    {
        // your logic ....
        echo $data.PHP_EOL;
    }
}

class Test
{
    public function ws()
    {
        $config = [
            'coinbase' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.pro.coinbase.com',
                'ws_base_uri' => 'ws://ws-feed.pro.coinbase.com',
                'app_key' => 'your app key',
                'secret' => 'your secret',
            ],
        ];
        $app = Factory::coinbase($config['coinbase']);
        $params = [
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
        $app->websocket->subscribe($params, new DataTest());
    }
}

$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`
