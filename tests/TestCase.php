<?php

namespace LaravelCacheable\Tests;

use LaravelCacheable\ServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }
}
