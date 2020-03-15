<?php

namespace LaravelCacheable\Aspects;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CachingAspect implements Aspect
{
    /**
     * @Around("@execution(LaravelCacheable\Annotations\Cacheable)")
     */
    public function aroundCacheable(MethodInvocation $invocation)
    {
        return $this->cacheWrap($invocation);
    }

    protected function cacheWrap(MethodInvocation $invocation)
    {
        /*if(!$this->shouldCacheMethod($name)) {
            return $this->{$name}(...$arguments);
        }*/

        $cacheKey = Str::slug($invocation->getMethod()->name . serialize($invocation->getArguments()));
        $cacheExpire = now()->addSeconds(
            $invocation->getMethod()->getAnnotation('LaravelCacheable\Annotations\Cacheable')->seconds
                ?? 1800
        );
        return Cache::remember($cacheKey, $cacheExpire, function () use ($invocation) {
            return $invocation->proceed();
        });
    }
}
