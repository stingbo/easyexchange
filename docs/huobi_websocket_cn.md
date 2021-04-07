## 火币 Websocket 行情数据

1. 示例
```php
<?php

namespace EasyExchange\Tests;

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\DataHandle;

class DataTest implements DataHandle
{
    public function handle($connection, $data)
    {
        $json_data = gzdecode($data);
        echo $json_data.PHP_EOL;
        $data = json_decode($json_data, true);
        if (isset($data['ping'])) {
            $connection->send(json_encode(['pong' => $data['ping']]));
        }
    }
}

class Test
{
    public function ws()
    {
        $config = [
            'huobi' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.huobi.pro',
                'ws_base_uri' => 'ws://api.huobi.pro',
                'app_key' => '17b00df5-54174f52-bg2hyw2dfg-4b2a0',
                'secret' => '47d43695-d44aabd1-ed1cbdbc-4d777',
            ],
        ];
        $app = Factory::huobi($config['huobi']);
        $params = [
            "sub" => "market.btcusdt.kline.1min",
        ];
        $handle = new DataTest();
        $app->websocket->subscribe($params, $handle);
    }
}


$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`