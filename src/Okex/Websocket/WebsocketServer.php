<?php

namespace EasyExchange\Okex\Websocket;

use EasyExchange\Kernel\Websocket\BaseClient;
use GlobalData\Server;

class Servera extends BaseClient
{
    public function server()
    {
        // 监听端口
        $worker = new Server('127.0.0.1', 2207);

        Worker::runAll();
    }
}
