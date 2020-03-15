<?php

namespace LaravelCacheable;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        $applicationAspectKernel->init([
            'debug'        => true,
            'cacheDir'     => storage_path('framework/cache/laravel-cacheable'),
            'includePaths' => [
                __DIR__ . '/../tests/Implementations'
            ]
        ]);
    }
}