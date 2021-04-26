<?php

namespace EasyExchange\Kernel\Websocket;

use EasyExchange\Kernel\ServiceContainer;
use GlobalData\Client;

class BaseClient
{
    public $client;

    /**
     * BaseClient constructor.
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->client = new Client('127.0.0.1:2207');
    }
}
