<?php

namespace LaravelCacheable\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelCacheable\Tests\Implementations\CacheableImplementation;
use LaravelCacheable\Tests\TestCase;

class CacheableTest extends TestCase
{
    /** @var CacheableImplementation */
    private $cacheable;

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
