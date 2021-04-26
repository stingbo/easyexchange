<?php

namespace EasyExchange\Kernel\Websocket;

use EasyExchange\Kernel\ServiceContainer;
use GlobalData\Client;
use GlobalData\Server;
use Workerman\Timer;
use Workerman\Worker;

class BaseServer
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
    public function server($params, Handle $handle)
    {
        $config = $this->app->getConfig();
        $worker = new Worker();
        new Server('127.0.0.1', 2207);
        $worker->onWorkerStart = function () use ($config, $params, $handle) {
            $this->client = new Client('127.0.0.1:2207');
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

            Timer::add(20, function () use ($ws_connection) {
                $ws_connection->send('ping');
            });
            $ws_connection->timer_id = Timer::add(2, function () use ($ws_connection) {
                $data = [
                    'op' => 'subscribe',
                    'args' => [
                            [
                                'channel' => 'instruments',
                                'instType' => 'SPOT', // Required
                            ],
                        ],
                ];

                $data = json_encode($data);
                $ws_connection->send($data);
            });
        };
        Worker::runAll();
    }
}
