<?php

namespace EasyExchange\Kernel\Websocket;

use EasyExchange\Kernel\ServiceContainer;
use Workerman\Connection\AsyncTcpConnection;
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
    public function request(string $url, $params, Handle $handle)
    {
        $ws_base_uri = $this->app->config->get('ws_base_uri').$url;
        $worker = new Worker();
        $worker->onWorkerStart = function () use ($ws_base_uri, $params, $handle) {
            $ws_connection = new AsyncTcpConnection($ws_base_uri);
            $ws_connection->transport = 'ssl';
            $ws_connection->onConnect = function ($connection) use ($params, $handle) {
                $handle->onConnect($connection, $params);
            };
            $ws_connection->onMessage = function ($connection, $data) use ($handle) {
                $handle->onMessage($connection, $data);
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
