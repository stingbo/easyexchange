## Gate Websocket

#### Introduction

See [binance websocket documentation](binance_websocket.md) for details

### Usage

1. Example

```php
<?php

use EasyExchange\Factory;
use EasyExchange\Kernel\Websocket\Handle;

class GateHandle implements Handle
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
