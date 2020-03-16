<p align="center">
<img src="https://app.codeship.com/projects/d6932780-493c-0138-c924-5a0b9e4d4110/status?branch=master" alt="Build Status">
<img src='https://coveralls.io/repos/github/ChrGriffin/laravel-cacheable/badge.svg?branch=master' alt='Coverage Status' />
</p>

# Laravel Cacheable

`laravel-cacheable` makes it easy to automagically cache the results of any arbitrary class method, using your configured Laravel cache driver, by simply adding a docblock annotation to that method.

```php
class MyClass
{
    /** @Cache(seconds=3600) */
    public function cacheMe(): string 
    {
        return 'Hello!';
    }
}
```

## Installation

Install in your Laravel project via composer:

```shell script
composer install chrgriffin/laravel-cacheable
```

If your version of Laravel supports auto-discovery (5.5 and up), you're done!

For older versions of Laravel, you'll need to edit your `config/app.php` file to include the service provider in your providers array:

```php
return [
    // ...
    'providers' => [
        // ...
        LaravelCacheable\ServiceProvider::class
    ]
];
```

## Usage

### Configuration (optional)

`laravel-cacheable` uses [GOAOP](https://github.com/goaop/framework) to build cached versions of your classes which then have a method interceptor applied to it. The package will, by default, use your Laravel framework cache directory as its cache. It will also, by default, search for Cache annotations in your entire `app` directory. Both of these configs can be overridden. First, copy the package config:

```shell script
php artisan vendor:publish --provider="LaravelCacheable\ServiceProvider"
```

Now, in `config/laravel-cacheable.php`, you can override the default package configs:

```php
return [
    'cache' => [
        // this is where laravel-cacheable will store cached versions of your classes
        storage_path('framework/cache/laravel-cacheable')
    ],
    // this is an array of all the paths laravel-cacheable will 'scan' for Cache annotations
    'paths' => [
        app_path()
    ]
];
```

### Caching Method Returns

Now that the package is installed, caching the results of a method call is as easy as [making sure your Laravel cache is set up](https://laravel.com/docs/master/cache) and then adding an annotation to your method:

```php
class MyClass
{
    /** @Cache */
    public function cacheMe(): string 
    {
        return 'Hello!';
    }
}
```

#### Specifying a Custom Cache Time

By default, `laravel-cacheable` will cache a method return for 30 minutes. If you want to cache a method for a different length of time, you can add a `seconds` property to the annotation:

```php
class MyClass
{
    /** @Cache(seconds=3600) */
    public function cacheMe(): string 
    {
        return 'Hello!';
    }
}
```

### Advanced Behaviours

The docblock alone is enough to automatically cache the results of a method. For more advanced behaviours, you will also need to use the `Cacheable` trait:

```php
class MyClass
{
    use \LaravelCacheable\Traits\Cacheable;

    /** @Cache(seconds=3600) */
    public function cacheMe(): string 
    {
        return 'Hello!';
    }
}
```

#### Bypassing the Cache

Once your class is using the `Cacheable` trait, you can bypass the trait by chaining `->withoutCache()` before your method call:

```php
// bypasses cache
(new MyClass())->withoutCache()->cacheMe();
```

Note that this will bypass both getting _and_ setting the cache -- the return of this method will not be cached.

### Notes

`laravel-cacheable` checks both the method name and the passed arguments to determine if the return should be pulled from cache or not. If different arguments are passed, a new cache index will be created.

```php
(new MyClass())->cacheMe('argument 1');

// this method call will not use the cached return from the first one
(new MyClass())->cacheMe('argument 2');
```