<?php

namespace LaravelCacheable\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Cache extends Annotation
{
    public $seconds = 1800;
}
