<?php

namespace LaravelCacheable\Tests\Unit;

use LaravelCacheable\Tests\Mocks\CacheableClass;
use LaravelCacheable\Tests\TestCase;

class CacheableTest extends TestCase
{
    /** @var CacheableClass */
    private $cacheable;

    public function setUp(): void
    {
        parent::setUp();
        $this->cacheable = new CacheableClass();
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
}
