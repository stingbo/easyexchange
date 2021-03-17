<?php

namespace EasyExchange\Okex;

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
        Basic\ServiceProvider::class,
        Market\ServiceProvider::class,
        Trade\ServiceProvider::class,
    ];
}
