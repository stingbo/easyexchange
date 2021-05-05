## 欧易 Websocket 文档

#### 说明

详见[币安 websocket 文档](binance_websocket_cn.md)

1. 示例
```php
<?php

use EasyExchange\Factory;
use Workerman\Timer;

class OkexHandle extends \EasyExchange\Okex\Websocket\Handle
{
    public function onMessage($connection, $params, $data)
    {
        // 执行内置的login方法
        parent::onMessage($connection, $params, $data);

        // 处理你自己的逻辑
        echo $data.PHP_EOL;
        $time_interval = 20;
        if ('pong' != $data) {
            $connection->timer_id = Timer::add($time_interval, function () use ($connection) {
                $connection->send('ping');
            });
        } else {
            // 删除定时器
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
        // 私有频道必须配置 auth 参数
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

2. 启动脚本监听:`php test.php start`
