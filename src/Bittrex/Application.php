<?php

namespace EasyExchange\Bittrex;

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
    ];
}
