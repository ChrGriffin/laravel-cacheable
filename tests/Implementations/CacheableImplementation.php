<?php

namespace LaravelCacheable\Tests\Implementations;

use LaravelCacheable\Annotations\Cache;

class CacheableImplementation
{
    /** @var string */
    private $response;

    public function setResponse(string $response): CacheableImplementation
    {
        $this->response = $response;
        return $this;
    }

    /** @Cache */
    public function defaultCacheMethod(): string
    {
        return $this->response;
    }

    /** @Cache(seconds=3600) */
    public function userDefinedTimeCacheMethod(): string
    {
        return $this->response;
    }
}
