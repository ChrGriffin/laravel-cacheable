<?php

namespace LaravelCacheable;

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use LaravelCacheable\Aspects\CachingAspect;

/**
 * Application Aspect Kernel
 */
class ApplicationAspectKernel extends AspectKernel
{
    protected function configureAop(AspectContainer $container): void
    {
        $container->registerAspect(new CachingAspect());
    }
}