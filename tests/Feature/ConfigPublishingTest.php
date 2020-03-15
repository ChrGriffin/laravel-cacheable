<?php

namespace LaravelCacheable\Tests\Feature;

use LaravelCacheable\Tests\TestCase;

class ConfigPublishingTest extends TestCase
{
    public function testItProvidesADefaultConfig()
    {
        $this->assertNotEmpty(config('laravel-cacheable'));
    }
}