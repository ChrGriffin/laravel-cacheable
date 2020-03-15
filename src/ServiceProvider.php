<?php

namespace LaravelCacheable;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /** @var ApplicationAspectKernel */
    private static $kernel;

    public static function getKernel(): ?ApplicationAspectKernel
    {
        return self::$kernel;
    }

    public function boot(): void
    {
        self::$kernel = $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        self::$kernel->init([
            'debug'        => config('app.debug'),
            'cacheDir'     => config(
                'laravelCacheable.cache.path',
                storage_path('framework/cache/laravel-cacheable')
            ),
            'includePaths' => config(
                'laravelCacheable.paths',
                [__DIR__ . '/../tests/Implementations']
            )
        ]);
    }
}