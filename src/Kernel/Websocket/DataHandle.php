<?php

namespace EasyExchange\Kernel\Websocket;

interface DataHandle
{
    public function handle($connection, $data);
}
