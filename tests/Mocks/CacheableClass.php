<?php

namespace LaravelCacheable\Tests\Mocks;

use LaravelCacheable\Cacheable;

class CacheableClass extends Cacheable
{
    /** @var string */
    private $response;

    /** @var string[] */
    protected $cacheMethods = [
        'thisMethodShouldCacheItsResponse'
    ];

    public function setResponse(string $response): CacheableClass
    {
        $this->response = $response;
        return $this;
    }

    protected function thisMethodShouldCacheItsResponse(): string
    {
        return $this->response;
    }

    protected function thisMethodShouldNotCacheItsResponse(): string
    {
        return $this->response;
    }
}
