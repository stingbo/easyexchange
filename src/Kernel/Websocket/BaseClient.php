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
    public function request(string $url, $params, DataHandle $data_handle)
    {
        $ws_base_uri = $this->app->config->get('ws_base_uri').$url;
        $worker = new Worker();
        $worker->onWorkerStart = function () use ($ws_base_uri, $params, $data_handle) {
            $ws_connection = new AsyncTcpConnection($ws_base_uri);
            $ws_connection->transport = 'ssl';
            $ws_connection->onConnect = function ($connection) use ($params) {
                $connection->send(json_encode($params));
            };
            $ws_connection->onMessage = function ($connection, $data) use ($data_handle) {
                $data_handle->handle($connection, $data);
            };
            $ws_connection->onError = function ($connection, $code, $msg) {
                echo "error: $msg\n";
            };
            $ws_connection->onClose = function ($connection) {
                echo "connection closed\n";
            };
            $ws_connection->connect();
        };
        Worker::runAll();
    }
}
