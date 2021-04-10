## 欧易 Websocket 文档

#### 说明

见[币安 websocket 文档](binance_websocket_cn.md)

1. 示例
```php
<?php

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\Handle;
use Workerman\Timer;

class OkexHandle implements Handle
{
    public function onConnect($connection, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $data)
    {
        echo $data.PHP_EOL;
        $time_interval = 10;
        $connect_time = time();
        if ('pong' != $data) {
            $connection->timer_id = Timer::add($time_interval, function () use ($connection, $connect_time) {
                echo $connect_time.PHP_EOL;
                $connection->send('ping');
            });
        } else {
            // 删除定时器
            Timer::del($connection->timer_id);
        }
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
        $app->websocket->subscribe($params, new OkexHandle());
    }
}

$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`
