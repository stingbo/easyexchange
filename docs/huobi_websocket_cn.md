## 火币 Websocket 文档

#### 说明

详见[币安 websocket 文档](binance_websocket_cn.md)


1. 示例
```php
<?php

use EasyExchange\Factory;
use EasyExchange\Huobi\Websocket\Handle;

class HuobiHandle extends Handle
{
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
