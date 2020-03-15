<?php

namespace LaravelCacheable\Tests\Feature;

use LaravelCacheable\ServiceProvider;
use LaravelCacheable\Tests\TestCase;

class AopConfigTest extends TestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.debug', true);
        $app['config']->set('laravel-cacheable.cache.path', __DIR__ . 'Geralt of Rivia');
        $app['config']->set('laravel-cacheable.paths', [__DIR__ . 'Yennefer of Vengerberg']);
    }

    public function testItUsesLaravelCacheableConfigForAopOptions(): void
    {
        $this->assertEquals(__DIR__ . 'Geralt of Rivia', ServiceProvider::getKernel()->getOptions()['cacheDir']);
        $this->assertEquals(
            [__DIR__ . 'Yennefer of Vengerberg'],
            ServiceProvider::getKernel()->getOptions()['includePaths']
        );
    }

    public function testItUsesAppDebugForAopDebugSetting(): void
    {
        $this->assertTrue(ServiceProvider::getKernel()->getOptions()['debug']);
    }
}