<?php

namespace LaravelCacheable;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait Cacheable
{
    /** @var bool */
    protected $forceCache = false;

    /** @var bool */
    protected $forceNoCache = false;

    /** @var null|int */
    protected $cacheSeconds = null;

    public function cache()
    {
        $this->forceCache = true;
        $this->forceNoCache = false;
        return $this;
    }

    public function withoutCache()
    {
        $this->forceNoCache = true;
        $this->forceCache = false;
        return $this;
    }

    public function __call($name, $arguments)
    {
        return $this->cacheWrap($name, $arguments);
    }

    protected function cacheWrap(string $name, $arguments)
    {
        if(!$this->shouldCacheMethod($name)) {
            return $this->{$name}(...$arguments);
        }

        $cacheKey = $name . Str::slug(serialize($arguments));
        $cacheExpire = now()->addSeconds($this->cacheSeconds ?? 1800);
        return Cache::remember($cacheKey, $cacheExpire, function () use ($name, $arguments) {
            return $this->{$name}(...$arguments);
        });
    }

    protected function shouldCacheMethod(string $name): bool
    {
        if($this->forceCache) {
            return true;
        }

        if($this->forceNoCache) {
            return false;
        }

        return in_array($name, $this->cacheMethods);
    }
}
