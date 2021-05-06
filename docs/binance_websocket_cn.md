## 币安 Websocket 文档

#### 说明

* BinanceHandle 必须实现 `EasyExchange\Kernel\Websocket\Handle` 接口
或者 继承系统内置 `EasyExchange\Binance\Websocket\Handle` 对象

* 这样设计是为了让开发更灵活，更加方便用户定制自己的逻辑

* Handle 定义：

    > 1. getConnection 获取连接对象
                
    > 2. onConnect 连接时触发

    > 3. onMessage 通讯时触发

    > 4. onError 连接上发生错误时触发

    > 5. onClose 服务器的连接断开时触发

* 参数定义：

    > 1. config 配置参数
           
    > 2. connection Workerman 客户端连接对象

    > 3. params 客户端请求参数

    > 4. data 服务端返回数据

    > 5. code 服务端返回错误编码

    > 6. message 服务端返回错误信息

1. 示例

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Binance\Socket\Handle;
use Workerman\Connection\AsyncTcpConnection;

class BinanceHandle extends Handle
{
    public function getConnection($config, $params)
    {
        $ws_base_uri = $config['ws_base_uri'].'/ws';

        $connection = new AsyncTcpConnection($ws_base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $params, $data)
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
