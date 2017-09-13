# laravel-router-cache

路由缓存 通过apcu缓存特定路由，优化性能

## 安装

```shell
composer require lilocon/laravel-router-cache
```

## 配置

注册 `ServiceProvider`(5.5+ 版本不需要手动注册):

```php
\Lilocon\RouterCache\RouterCacheServiceProvider,
```

## 使用

在需要缓存的路由上加一个中间件 router.cache

```php
Route::any('/api', 'ApiController@api')->name('api')->middleware('router.cache');
```

注意：只有命名的路由才会被缓存

注意：只有关闭debug才会生效

## License

MIT