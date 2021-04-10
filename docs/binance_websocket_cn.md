## 币安 Websocket 文档

#### 说明

* BinanceHandle 必须是实现了 `EasyExchange\Kernel\Websocket\Handle` 接口的对象

* 这样设计是为了让开发更灵活，更加方便用户定制自己的逻辑

* Handle 定义：

    > 1. onConnect 连接时触发

    > 2. onMessage 通讯时触发

    > 3. onError 连接上发生错误时触发

    > 4. onClose 服务器的连接断开时触发

* 参数定义：

    > 1. connection Workerman 客户端连接对象

    > 2. params 客户端请求参数

    > 3. data 服务端返回数据

    > 4. code 服务端返回错误编码

    > 5. message 服务端返回错误信息

1. 示例

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\Handle;

class BinanceHandle implements Handle
{
    public function onConnect($connection, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $data)
    {
        echo $data.PHP_EOL;
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
            'id' => 1,
            'params' => [
                "btcusdt@aggTrade",
                "btcusdt@depth"
            ],
        ];
        $app->websocket->subscribe($params, new BinanceHandle());
    }
}

$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`
