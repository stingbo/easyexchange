## 币安 Websocket 行情数据

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
            'params' => [
                "btcusdt@aggTrade",
                "btcusdt@depth"
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
