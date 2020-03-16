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

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/laravel-cacheable.php', 'laravel-cacheable');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/laravel-cacheable.php'
        ]);

        self::$kernel = $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        self::$kernel->init([
            'debug'        => config('app.debug'),
            'cacheDir'     => config(
                'laravel-cacheable.cache.path',
                storage_path('framework/cache/laravel-cacheable')
            ),
            'includePaths' => config(
                'laravel-cacheable.paths',
                [__DIR__ . '/../tests/Implementations']
            )
        ]);
    }
}