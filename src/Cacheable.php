<?php

namespace LaravelCacheable;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class Cacheable
{
    public function __call($name, $arguments)
    {
        if(!in_array($name, $this->cacheMethods)) {
            return $this->{$name}(...$arguments);
        }

        return Cache::remember($name . Str::slug(serialize($arguments)), 30, function () use ($name, $arguments) {
            return $this->{$name}(...$arguments);
        });
    }
}
