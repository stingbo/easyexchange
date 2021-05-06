## Coinbase Websocket 文档

#### 说明

见[币安 websocket 文档](binance_websocket_cn.md)

1. 示例

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Coinbase\Socket\Handle;

class CoinbaseHandle extends Handle
{
}

class Test
{
    public function ws()
    {
        $config = [
            'coinbase' => [
                'response_type' => 'array',
                'base_uri' => 'https://api.pro.coinbase.com',
                'ws_base_uri' => 'ws://ws-feed.pro.coinbase.com',
                'app_key' => 'your app key',
                'secret' => 'your secret',
            ],
        ];
        $app = Factory::coinbase($config['coinbase']);
        $params = [
            'product_ids' => [
                'ETH-USD',
                'ETH-EUR'
            ],
            'channels' => [
                'level2',
                'heartbeat',
                [
                    'name' => 'ticker',
                    'product_ids' => [
                        'ETH-BTC',
                        'ETH-USD'
                    ],
                ],
            ],
        ];
        $app->websocket->subscribe($params, new CoinbaseHandle());
    }
}

$tc = new Test();
$tc->ws();
```

2. 启动脚本监听:`php test.php start`
