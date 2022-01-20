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

    > 7. client Workerman GlobalData\Client

1. 启动本地服务，server.php 示例:

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Binance\Socket\Handle;
use Workerman\Connection\AsyncTcpConnection;

/**
* Class BinanceHandle
 */
class BinanceHandle extends Handle
{
    public function getConnection($config, $params)
    {
        $ws_base_uri = $config['ws_base_uri'].'/ws';

        $connection = new AsyncTcpConnection($ws_base_uri);
        $connection->transport = 'ssl';

        return $connection;
    }

    public function onConnect($connection, $client, $params)
    {
        $connection->send(json_encode($params));
    }

    public function onMessage($connection, $client, $params, $data)
    {
        echo $data.PHP_EOL;
        // your logic ....
    }

    public function onError($connection, $client, $code, $message)
    {
        echo "error: $message\n";
    }

    public function onClose($connection, $client)
    {
        echo "connection closed\n";
    }
}

class Server
{
    public function ws()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://testnet.binance.vision',
                'app_key' => 'your app key',
                'secret' => 'your secret',
                'websocket' => [
                    'base_uri' => 'ws://stream.binance.com:9443',
                    'listen_ip' => '127.0.0.1', // 监听的本机ip地址
                    'listen_port' => 2207, // 监听的端口
                    'heartbeat_time' => 20, // 心跳检测时间，单位秒
                    'timer_time' => 3, // 定时任务间隔时间，秒
                    'max_size' => 100, // 数据保留量，1～1000，数据按频道名称存储
                    'data_time' => 1, // 获取数据的时间间隔，秒
                ],
            ],
        ];

        $app = Factory::binance($config['binance']);
        // 你可以自定义自己的Handle，也可以使用系统里提供的 \EasyExchange\Binance\Socket\Handle::class();
        $app->websocket->server([], new Handle());
    }
}

$tc = new Server();
$tc->ws();
```

2. 启动脚本监听:`php server.php start`

3. 本地客户端示例
```php
<?php

use EasyExchange\Factory;

class Test
{
    public function t()
    {
        $config = [
            'binance' => [
                'response_type' => 'array',
                'base_uri' => 'https://testnet.binance.vision',
                'app_key' => 'your app key',
                'secret' => 'your secret',
                'websocket' => [
                    'base_uri' => 'ws://stream.binance.com:9443',
                    'listen_ip' => '127.0.0.1', // 监听的本机ip地址
                    'listen_port' => 2207, // 监听的端口
                    'heartbeat_time' => 20, // 心跳检测时间，单位秒
                    'timer_time' => 3, // 定时任务间隔时间，秒
                    'max_size' => 100, // 数据保留量，1～1000，数据按频道名称存储
                    'data_time' => 1, // 获取数据的时间间隔，秒
                ],
            ],
        ];
        $app = Factory::binance($config['binance']);
        $params = [
            'method' => 'SUBSCRIBE',
            'id' => 1,
            'params' => [
                "btcusdt@aggTrade",
                "btcusdt@depth"
            ],
        ];
        // 订阅
        $app->websocket->subscribe($params);

        $params = [
            'method' => 'UNSUBSCRIBE',
            'id' => 1,
            'params' => [
                "btcusdt@aggTrade",
                "btcusdt@depth"
            ],
        ];
        // 取消订阅
        $app->websocket->unsubscribe($params);

        // 获取已订阅的频道
        $channels = $app->websocket->getSubChannel();
        print_r($channels);

        // 根据频道获取数据，不传频道默认获取所有已订阅频道的数据
        $channels = ['aggTrade', 'trade'];
        $data = $app->websocket->getChannelData($channels);
        print_r($data);

        // 使用函数处理数据
        $app->websocket->getChannelData($channels, function ($data) {
            print_r($data);
        });

        // 使用守护进程和函数处理数据
        $app->websocket->getChannelData($channels, function ($data) {
            print_r($data);
        }, true);
    }
}

$tc = new Test();
$tc->t();
```
