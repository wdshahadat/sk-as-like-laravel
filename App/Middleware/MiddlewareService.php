<?php

namespace App\Middleware;

use App\Traits\MiddlewareTrait;
use App\Http\Services\Request;

class MiddlewareService
{
    use MiddlewareTrait;
    protected static string $uri;
    protected static Request $request;
    protected static array $uriStore = [];
    protected static array $routeParams = [];
    public static string $requestMethod = '';

    public static function middleware($middleware = [])
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (URI === array_key_last(self::$uriStore[$method])) {
            $keyArg = explode(':', $middleware[0]);
            $middle = 'App\\Middleware\\' . trim($keyArg[0]);
            $middle = new $middle;
            $guardKey = $keyArg[1];
            return $middle->handle($guardKey);
        }
    }

    public static function groups($middleware = [])
    {
    }
}
