<?php

namespace EasyExchange\Okex\Websocket;

use EasyExchange\Kernel\Websocket\BaseServer;

class WebsocketServer extends BaseServer
{
    public function start()
    {
        $this->server([], new Handle());
    }

    public function action($con, $global)
    {
        $time = 2;
    }
}
