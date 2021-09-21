<?php

namespace App\Http\Services;

use App\Traits\RouteServiceTrait;
use App\Http\Services\Request;
use App\Middleware\MiddlewareService;

abstract class RouteService extends MiddlewareService
{
    use RouteServiceTrait;

    protected static $default = 'App\\Http\\Controllers\\';


    public static function load()
    {
        $data = $_REQUEST;
        self::$request = new Request();

        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (!empty($data)) {
            $data = self::$request->validator($data);
            foreach ($data as $key => $value) {
                $value = filter_input($method === 'get' ? INPUT_GET : INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $value = is_int($value) ? intval($value) : $value;
                self::$request->$key = $value;
                Request::$requestData[$key] = $value;
            }
        }

        if (!empty(self::$routeParams)) {
            self::$request->urlParams(self::$routeParams);
            foreach (self::$routeParams as $k => $value) {
                self::$request->$k = $value;
            }
        }
    }

    private static function uri()
    {
        $uri = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI'];
        $uri = urldecode(parse_url($uri, PHP_URL_PATH));
        $uri = basename(ROOT) === basename($uri) ? '/' : $uri;
        self::$uri = str_replace(NEED_REPLACE, '', $uri);
        return self::$uri;
    }


    public static function hasRoutParams($uri)
    {
        $route = array_merge(...array_values(self::$uriStore));

        if (isset($route[$uri]) && is_array($route[$uri])) {
            return array_key_exists('params', $route[$uri]) ? $route[$uri]['params'] : false;
        } elseif (isset($route[$uri]) && is_callable($route[$uri])) {
            return false;
        }
        return null;
    }

    private static function storeRequests($method, $uri, $callback = false)
    {
        if ($callback) {
            $callback = is_string($callback) ? explode('@', $callback) : $callback;
            $paramsIndex = strpos($uri, '{');
            if ($paramsIndex) {
                $params = substr($uri, $paramsIndex, strlen($uri));

                if (is_callable($callback)) {
                    $callback = [$callback, 'params' => $params];
                } else {
                    $callback['params'] = $params;
                }

                $uri = str_replace($params, '', $uri);
                self::$uriStore[$method][$uri] = $callback;
            } else {
                self::$uriStore[$method][$uri] = $callback;
            }
        } else {
            if (strtolower($_SERVER['REQUEST_METHOD']) !== $method) {
                return false;
            }
            $store = self::$uriStore[$method];
            $callback = $store && isset($store[$uri]) ? $store[$uri] : false;


            if (!$callback && !empty($store)) {
                foreach ($store as $solidPath => $callAble) {
                    if (is_array($callAble) && isset($callAble['params']) && strpos($uri, $solidPath) === 0) {
                        $routeParams = self::getRouteParams($uri, $solidPath, $callAble['params']);
                        if (!empty($routeParams)) {
                            self::$routeParams = $routeParams;

                            // $data = $request->validator($data);
                            // if (!empty(self::$routeParams)) {
                            //     $request->urlParams(self::$routeParams);
                            //     foreach (self::$routeParams as $k => $value) {
                            //         $request->$k = $value;
                            //     }
                            // }

                            unset($callAble['params']);
                            $callback = $callAble;
                        }
                    }
                }
            }

            if ($callback) {
                self::load();
            }
            return $callback;
        }
    }

    private static function getRouteParams($url, $solidPath, $paramsPattern)
    {
        $processedPattern = implode('/', array_map(function ($a) {
            return substr_replace($a, '(\d+|\w+)', strpos($a, '{'), strpos($a, '}') + 1);
        }, explode('/', $paramsPattern)));
        $pattern = "~^{$solidPath}{$processedPattern}/?$~";
        $params = preg_match($pattern, $url, $matches) ? $matches : false;

        if (is_array($params)) {
            array_shift($params);
            return array_combine(explode('/', str_replace(['{', '}'], '', $paramsPattern)), $params);
        }
        return [];
    }


    private static function resolve()
    {
        $output = '>~@~<';
        self::$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $callback = self::storeRequests(self::$requestMethod, self::uri());

        $_SESSION["history3"] = isset($_SESSION["history3"]) ? $_SESSION["history3"] : [];

        if ($callback) {
            if (is_callable($callback)) {
                $_SESSION['history3'][CURRENT_URI] = CURRENT_URI;
                $output = call_user_func($callback, self::$request, ...array_values(self::$routeParams));
            } else {
                $controller = self::$default . str_replace(self::$default, '', $callback[0]);
                $controller = str_replace('\\\\', '\\', $controller);
                $controller = new $controller;
                $method = $callback[1];

                if (method_exists($controller, $method) && get_class_methods($controller)) {
                    $_SESSION['history3'][CURRENT_URI] = CURRENT_URI;
                    $output = call_user_func([$controller, $method], self::$request, ...array_values(self::$routeParams));
                } else {
                    $output = notFound();
                }
            }
        } else {
            $output = notFound();
        }

        if (is_bool($output) || $output !== '>~@~<') {
            echo is_string($output) ? $output : json_encode($output);
        }

        if (count($_SESSION["history3"]) > 2) {
            array_shift($_SESSION["history3"]);
        }
        return false;
    }


    public static function get($uri, $callback)
    {
        self::storeRequests('get', $uri, $callback);
        return new static();
    }
    public static function post($uri, $callback)
    {
        self::storeRequests('post', $uri, $callback);
        return new static();
    }
    public static function patch($uri, $callback)
    {
        self::storeRequests('patch', $uri, $callback);
        return new static();
    }
    public static function delete($uri, $callback)
    {
        self::storeRequests('delete', $uri, $callback);
        return new static();
    }

    public static function app()
    {
        return self::resolve();
    }
}
