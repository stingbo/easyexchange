<?php

namespace EasyExchange\Binance\Websocket;

use EasyExchange\Binance\Kernel\BaseClient;
use Workerman\Connection\AsyncTcpConnection;
use Workerman\Worker;

class Client extends BaseClient
{
    public function subscribe($params)
    {
        $params['method'] = 'SUBSCRIBE';

        $worker = new Worker();
        // 进程启动时
        $worker->onWorkerStart = function () use ($params) {
            // 以websocket协议连接远程websocket服务器
            $ws_connection = new AsyncTcpConnection('ws://stream.binance.com:9443/ws');
            $ws_connection->transport = 'ssl';
            // 连上后发送hello字符串
            $ws_connection->onConnect = function ($connection) use ($params) {
                echo 'connected'.PHP_EOL;
                $connection->send(json_encode($params));
            };
            // 远程websocket服务器发来消息时
            $ws_connection->onMessage = function ($connection, $data) {
                echo "recv: $data\n";
            };
            // 连接上发生错误时，一般是连接远程websocket服务器失败错误
            $ws_connection->onError = function ($connection, $code, $msg) {
                echo "error: $msg\n";
            };
            // 当连接远程websocket服务器的连接断开时
            $ws_connection->onClose = function ($connection) {
                echo "connection closed\n";
            };
            // 设置好以上各种回调后，执行连接操作
            $ws_connection->connect();
        };
        Worker::runAll();
    }
}
