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

    public function testItCachesTheReturnOfAMethodIndicatedInTheClassProperty(): void
    {
        $this->cacheable->setResponse('Geralt of Rivia');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->thisMethodShouldCacheItsResponse());

        $this->cacheable->setResponse('Yennefer of Vengerberg');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->thisMethodShouldCacheItsResponse());
    }

    public function testItDoesNotCacheTheReturnOfAMethodNotIndicatedInTheClassProperty(): void
    {
        $this->cacheable->setResponse('Geralt of Rivia');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->thisMethodShouldNotCacheItsResponse());

        $this->cacheable->setResponse('Yennefer of Vengerberg');
        $this->assertEquals('Yennefer of Vengerberg', $this->cacheable->thisMethodShouldNotCacheItsResponse());
    }

    public function testItCanBeForcedToUseCache(): void
    {
        $this->cacheable->setResponse('Geralt of Rivia');
        $this->assertEquals(
            'Geralt of Rivia',
            $this->cacheable->cache()->thisMethodShouldNotCacheItsResponse()
        );

        $this->cacheable->setResponse('Yennefer of Vengerberg');
        $this->assertEquals(
            'Geralt of Rivia',
            $this->cacheable->cache()->thisMethodShouldNotCacheItsResponse()
        );
    }

    public function testItCanBeForcedToNotUseCache(): void
    {
        $this->cacheable->setResponse('Geralt of Rivia');
        $this->assertEquals(
            'Geralt of Rivia',
            $this->cacheable->withoutCache()->thisMethodShouldCacheItsResponse()
        );

        $this->cacheable->setResponse('Yennefer of Vengerberg');
        $this->assertEquals(
            'Yennefer of Vengerberg',
            $this->cacheable->withoutCache()->thisMethodShouldCacheItsResponse()
        );
    }

    public function testItCachesForThirtyMinutesByDefault(): void
    {
        Carbon::setTestNow(now());

        $this->cacheable->setResponse('Geralt of Rivia');
        $this->cacheable->thisMethodShouldCacheItsResponse();

        $cachedResponse = DB::table('cache')->get()->first();
        $this->assertEquals(now()->addMinutes(30)->timestamp, $cachedResponse->expiration);
    }

    public function testItUsesClassPropertyToOverrideCacheTime(): void
    {
        Carbon::setTestNow(now());

        $this->cacheable->setResponse('Geralt of Rivia');
        $this->cacheable->setCacheSeconds(60);
        $this->cacheable->thisMethodShouldCacheItsResponse();

        $cachedResponse = DB::table('cache')->get()->first();
        $this->assertEquals(now()->addMinutes(1)->timestamp, $cachedResponse->expiration);
    }
}
