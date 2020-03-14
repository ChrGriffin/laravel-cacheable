<?php

namespace LaravelCacheable;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class Cacheable
{
    public function __call($name, $arguments)
    {
        Cache::remember($name . Str::slug(serialize($arguments)), 30, function () use ($name, $arguments) {
            $this->{$name}(...$arguments);
        });
    }
}
