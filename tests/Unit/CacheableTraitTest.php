<?php

namespace LaravelCacheable\Tests\Unit;

use LaravelCacheable\Tests\Implementations\CacheableImplementationWithTrait;
use LaravelCacheable\Tests\TestCase;

class CacheableTraitTest extends TestCase
{
    /** @var CacheableImplementationWithTrait */
    private $cacheable;

    public function setUp(): void
    {
        parent::setUp();
        $this->cacheable = new CacheableImplementationWithTrait();
    }

    public function testItCanBeForcedNotToUseCache(): void
    {
        $this->cacheable->setResponse('Geralt of Rivia');
        $this->assertEquals('Geralt of Rivia', $this->cacheable->withoutCache()->defaultCacheMethod());

        $this->cacheable->setResponse('Yennefer of Vengerberg');
        $this->assertEquals('Yennefer of Vengerberg', $this->cacheable->withoutCache()->defaultCacheMethod());
    }
}
