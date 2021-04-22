<?php

namespace EasyExchange\Kernel\Websocket;

interface Handle
{
    public function getConnection($config, $params);

    public function onConnect($connection, $params);

    public function onMessage($connection, $params, $data);

    public function onError($connection, $code, $message);

    public function onClose($connection);
}
