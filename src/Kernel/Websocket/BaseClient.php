<?php

namespace EasyExchange\Kernel\Websocket;

use EasyExchange\Kernel\ServiceContainer;
use Workerman\Worker;

class BaseClient
{
    /**
     * BaseClient constructor.
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param $params
     */
    public function request($params, Handle $handle)
    {
        $config = $this->app->getConfig();
        $worker = new Worker();
        $worker->onWorkerStart = function () use ($config, $params, $handle) {
            $ws_connection = $handle->getConnection($config, $params);
            $ws_connection->onConnect = function ($connection) use ($params, $handle) {
                $handle->onConnect($connection, $params);
            };
            $ws_connection->onMessage = function ($connection, $data) use ($params, $handle) {
                $handle->onMessage($connection, $params, $data);
            };
            $ws_connection->onError = function ($connection, $code, $msg) use ($handle) {
                $handle->onError($connection, $code, $msg);
            };
            $ws_connection->onClose = function ($connection) use ($handle) {
                $handle->onClose($connection);
            };
            $ws_connection->connect();
        };
        Worker::runAll();
    }
}
