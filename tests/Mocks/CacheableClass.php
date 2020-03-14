<?php

namespace LaravelCacheable\Tests\Mocks;

use LaravelCacheable\Cacheable;

class CacheableClass extends Cacheable
{
    private $response;

    public function setResponse(string $response): CacheableClass
    {
        $this->response = $response;
        return $this;
    }

    protected function thisMethodShouldCacheItsResponse(): string
    {
        return $this->response;
    }
}
