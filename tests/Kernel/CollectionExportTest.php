<?php

namespace EasyExchange\Tests\Kernel;

use EasyExchange\Kernel\Config;
use EasyExchange\Kernel\Support\Collection;
use PHPUnit\Framework\TestCase;

class CollectionExportTest extends TestCase
{
    /**
     * @dataProvider exportedClasses
     */
    public function testExportRestoresConcreteObject(string $class): void
    {
        $original = new $class(['nested' => ['value' => '测试'], 'count' => 0]);
        $restored = eval('return '.var_export($original, true).';');

        $this->assertInstanceOf($class, $restored);
        $this->assertSame($original->all(), $restored->all());
    }

    public static function exportedClasses(): array
    {
        return [[Collection::class], [Config::class]];
    }
}
