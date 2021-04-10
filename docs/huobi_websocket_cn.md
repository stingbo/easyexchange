## 火币 Websocket 文档

#### 说明

见[币安 websocket 文档](docs/binance_websocket_cn.md)


1. 示例
```php
<?php

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\Handle;

class HuobiHandle implements Handle
{
    public function onConnect($connection, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $data)
    {
        $json_data = gzdecode($data);
        echo $json_data.PHP_EOL;
        $data = json_decode($json_data, true);
        if (isset($data['ping'])) {
            $connection->send(json_encode(['pong' => $data['ping']]));
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
            'huobi' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.huobi.pro',
                'ws_base_uri' => 'ws://api.huobi.pro',
                'app_key' => 'your app key',
                'secret' => 'your secret',
            ],
        ];
        $app = Factory::huobi($config['huobi']);
        $params = [
            "sub" => "market.btcusdt.kline.1min",
        ];
        $app->websocket->subscribe($params, new HuobiHandle());
    }
}

$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`