<?php

namespace LaravelCacheable\Tests\Implementations;

use LaravelCacheable\Annotations\Cache;
use LaravelCacheable\Traits\Cacheable as Cacheable;

class CacheableImplementationWithTrait
{
    use Cacheable;

    /** @var string */
    private $response;

    public function setResponse(string $response): CacheableImplementationWithTrait
    {
        $this->response = $response;
        return $this;
    }

    /** @Cache */
    public function defaultCacheMethod(): string
    {
        return $this->response;
    }
}
