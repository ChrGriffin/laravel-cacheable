<?php

namespace LaravelCacheable\Traits;

trait Cacheable
{
    public $forceNoCache = false;

    public function withoutCache()
    {
        $this->forceNoCache = true;
        return $this;
    }
}