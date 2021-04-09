## 芝麻开门 Websocket 文档

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
