<?php

namespace LaravelCacheable\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelCacheable\Tests\Implementations\CacheableImplementation;
use LaravelCacheable\Tests\TestCase;

class CachingAspectTest extends TestCase
{
    /** @var CacheableImplementation */
    private $cacheable;

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('laravel-cacheable.paths', [__DIR__ . '/../../tests/Implementations']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->cacheable = new CacheableImplementation();
    }

    public function testItCachesTheReturnOfAMethodAnnotatedAsCacheable(): void
    {
        $this->cacheable->setResponse('Geralt of Rivia');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->defaultCacheMethod());

        $this->cacheable->setResponse('Yennefer of Vengerberg');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->defaultCacheMethod());
    }

    public function testItCachesFor30MinutesByDefault(): void
    {
        Carbon::setTestNow(now());

        $this->cacheable->setResponse('Geralt of Rivia');
        $this->cacheable->defaultCacheMethod();

        $cachedResponse = DB::table('cache')->first();
        $this->assertEquals(now()->addMinutes(30)->timestamp, $cachedResponse->expiration);
    }

    public function testItCachesForThePassedNumberOfSecondsIfGiven(): void
    {
        Carbon::setTestNow(now());

        $this->cacheable->setResponse('Geralt of Rivia');
        $this->cacheable->userDefinedTimeCacheMethod();

        $cachedResponse = DB::table('cache')->first();
        $this->assertEquals(now()->addMinutes(60)->timestamp, $cachedResponse->expiration);
    }
}
