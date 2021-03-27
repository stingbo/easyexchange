<?php

namespace EasyExchange\Coinbase;

use EasyExchange\Kernel\ServiceContainer;

/**
 * Class Application.
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Market\ServiceProvider::class,
        User\ServiceProvider::class,
    ];
}
