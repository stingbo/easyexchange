## 币安 Websocket 文档

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
