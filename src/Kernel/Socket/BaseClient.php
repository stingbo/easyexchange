<?php

namespace EasyExchange\Kernel\Socket;

use EasyExchange\Kernel\ServiceContainer;
use EasyExchange\Kernel\Support\Arr;
use GlobalData\Client;
use GlobalData\Server;
use Workerman\Worker;

class BaseClient
{
    public $client;

    public $config;

    /**
     * BaseClient constructor.
     */
    public function __construct(ServiceContainer $app)
    {
        $this->config = $app->getConfig();
        $this->client = new Client($this->config['websocket']['listen_ip'].':'.$this->config['websocket']['listen_port']);
    }

    /**
     * @param $params
     */
    public function server($params, Handle $handle)
    {
        $worker = new Worker();

        // GlobalData Server
        new Server($this->config['websocket']['listen_ip'] ?? '127.0.0.1', $this->config['websocket']['listen_port'] ?? 2207);

        $worker->onWorkerStart = function () use ($params, $handle) {
            $this->client = new Client(($this->config['websocket']['listen_ip'] ?? '127.0.0.1').':'.($this->config['websocket']['listen_port'] ?? 2207));
            $ws_connection = $handle->getConnection($this->config, $params);
            $ws_connection->onConnect = function ($connection) use ($params, $handle) {
                $handle->onConnect($connection, $this->client, $params);
            };
            $ws_connection->onMessage = function ($connection, $data) use ($params, $handle) {
                $handle->onMessage($connection, $this->client, $params, $data);
            };
            $ws_connection->onError = function ($connection, $code, $msg) use ($handle) {
                $handle->onError($connection, $this->client, $code, $msg);
            };
            $ws_connection->onClose = function ($connection) use ($handle) {
                $handle->onClose($connection, $this->client);
            };
            $ws_connection->connect();

            // heartbeat
            $this->ping($ws_connection);

            // timer action
            $this->connect($ws_connection);
        };

        Worker::runAll();
    }

    /**
     * 更新或创建.
     *
     * @param $key
     * @param $value
     */
    public function updateOrCreate($key, $value)
    {
        if (!isset($this->client->{$key})) {
            $this->create($key, $value);
        } else {
            $this->update($key, $value);
        }
    }

    /**
     * 创建.
     *
     * @param $key
     * @param $value
     *
     * @throws \Exception
     */
    public function create($key, $value)
    {
        $this->client->add($key, $value);
    }

    /**
     * update.
     *
     * @param $key
     * @param $new_value
     *
     * @throws \Exception
     */
    public function update($key, $new_value)
    {
        do {
            $old_value = $this->client->{$key};
        } while (!$this->client->cas($key, $old_value, $new_value));
    }

    /**
     * 获取缓存的值.
     *
     * @param $key
     *
     * @return array|mixed
     */
    public function get($key)
    {
        if (!isset($this->client->{$key}) || empty($this->client->{$key})) {
            return [];
        }

        return $this->client->{$key};
    }

    /**
     * @param $key
     * @param $new_key
     */
    public function move($key, $new_key)
    {
        $data = $this->get($key);
        $new_data = $this->get($new_key);
        $result = Arr::merge($data, $new_data);
        $this->updateOrCreate($new_key, $result);
        $this->updateOrCreate($key, []);
    }

    /**
     * @param $key
     */
    public function delete($key)
    {
        $this->updateOrCreate($key, []);
    }
}
