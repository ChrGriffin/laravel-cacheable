<?php

namespace LaravelCacheable\Tests\Implementations;

use LaravelCacheable\Cacheable;

class CacheableImplementation
{
    use Cacheable;

    /** @var string */
    private $response;

    /** @var string[] */
    protected $cacheMethods = [
        'thisMethodShouldCacheItsResponse'
    ];

    public function setResponse(string $response): CacheableImplementation
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
