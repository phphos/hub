<?php

namespace PHPHos\Laravel\Routes;

use Illuminate\Support\Facades\Route;

class Router
{
    /**
     * 注册路由.
     * 
     * @param string $prefix 前缀.
     * @return void
     */
    public static function make(string $prefix): void
    {
        $uri = app('request')->getPathInfo();

        $uri = mb_substr($uri, strlen($prefix) + 2);

        $routes = explode('/', $uri);

        $action = count($routes) > 1 ? array_pop($routes) : 'index';

        $class = join('\\', array_map('ucfirst', $routes)) . 'Controller';

        Route::any($uri, $class . '@' . $action);
    }
}
