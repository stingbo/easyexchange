<?php

namespace EasyExchange\Kernel\Websocket;

interface Handle
{
    public function getConnection($config, $params);

    public function onConnect($connection, $client, $params);

    public function onMessage($connection, $client, $params, $data);

    public function onError($connection, $client, $code, $message);

    public function onClose($connection, $client);
}
