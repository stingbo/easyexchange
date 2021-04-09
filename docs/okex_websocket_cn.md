## 欧易 Websocket 行情数据

1. 示例
```php
<?php

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\DataHandle;

class DataTest implements DataHandle
{
    public function handle($connection, $data)
    {
        echo $data.PHP_EOL;
        // 应该使用一个定时器来维持连接
        $connection->send('ping');
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
        $handle = new DataTest();
        $app->websocket->subscribe($params, $handle);
    }
}


$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`
