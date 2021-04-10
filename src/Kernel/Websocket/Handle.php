<?php

namespace EasyExchange\Kernel\Websocket;

interface Handle
{
    public function onConnect($connection, $params);

    public function onMessage($connection, $data);

    public function onError($connection, $code, $message);

    public function onClose($connection);
}
