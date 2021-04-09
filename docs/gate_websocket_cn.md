## 芝麻开门 Websocket 数据

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
            'gate' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.gateio.ws',
                'ws_base_uri' => 'ws://api.gateio.ws',
                'app_key' => 'your app key',
                'secret' => 'your secret',
            ],
        ];
        $app = Factory::gate($config['gate']);
        $params = [
            'time' => time(),
            'channel' => 'spot.tickers',
            'payload' => ['BTC_USDT'],
        ];
        $handle = new DataTest();
        $app->websocket->subscribe($params, $handle);
    }
}


$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`
