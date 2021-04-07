<?php

namespace EasyExchange\Kernel;

use Workerman\Connection\AsyncTcpConnection;
use Workerman\Worker;

class WebsocketClient
{
    /**
     * WebsocketClient constructor.
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param $params
     */
    public function request(string $url, $params, callable $f)
    {
        $ws_base_uri = $this->app->config->get('ws_base_uri').$url;
        $worker = new Worker();
        $params['id'] = $worker->id;
        $worker->onWorkerStart = function () use ($ws_base_uri, $params, $f) {
            $ws_connection = new AsyncTcpConnection($ws_base_uri);
            $ws_connection->transport = 'ssl';
            $ws_connection->onConnect = function ($connection) use ($params) {
                $connection->send(json_encode($params));
            };
            $ws_connection->onMessage = function ($connection, $data) use ($f) {
                $f($connection, $data);
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
