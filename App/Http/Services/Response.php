<?php

namespace App\Http\Services;

class Response
{

    public static $temp;
    public static $session;
    private static Response $catch;

    public static function set()
    {
        if (!isset(self::$catch)) {
            self::$catch = new Response();
        }
        return self::$catch;
    }

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
}
