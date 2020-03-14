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

    public function testItCachesTheReturnOfAMethod(): void
    {
        $this->cacheable->setResponse('Geralt of Rivia');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->thisMethodShouldCacheItsResponse());

        $this->cacheable->setResponse('Yennefer of Vengerberg');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->thisMethodShouldCacheItsResponse());
    }
}
