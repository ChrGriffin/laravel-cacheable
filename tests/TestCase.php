<?php

namespace LaravelCacheable\Tests;

use LaravelCacheable\ApplicationAspectKernel;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->initializeAop();
    }

    private function initializeAop(): void
    {
        $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        $applicationAspectKernel->init([
            'debug'        => true,
            'cacheDir'     => storage_path('framework/cache'),
            'includePaths' => [
                __DIR__ . '/../tests/Implementations'
            ]
        ]);
    }
}
