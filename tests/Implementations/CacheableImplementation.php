<?php

namespace LaravelCacheable\Tests\Implementations;

use LaravelCacheable\Annotations\Cacheable;

class CacheableImplementation
{
    /** @var string */
    private $response;

    public function setResponse(string $response): CacheableImplementation
    {
        $this->response = $response;
        return $this;
    }

    /** @Cacheable */
    public function defaultCacheMethod(): string
    {
        return $this->response;
    }

    /** @Cacheable(seconds=3600) */
    public function userDefinedTimeCacheMethod(): string
    {
        return $this->response;
    }
}
