## Gate Websocket

#### Introduction

See [binance websocket documentation](binance_websocket.md) for details

### Usage

1. Example

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Huobi\Socket\Handle;

class GateHandle extends Handle
{
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
        $app->websocket->subscribe($params, new GateHandle());
    }
}

$tc = new Test();
$tc->ws();
```

2. Start script monitoring:`php test.php start`
