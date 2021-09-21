<?php

namespace App\Http\Services;

use App\Http\Services\RouteService;

class Route extends RouteService
{


    public function __construct()
    {
    }

    protected function redirectTo($to)
    {
        if ($to === CURRENT_URI && Route::$actionMethod === $_SERVER['REQUEST_METHOD']) {
            return false;
        }
        $to = str_replace(NEED_REPLACE, '', $to);
        $to = strpos($to, '/') === 0 ? substr($to, 1, strlen($to)) : $to;
        $_SESSION['old'] = Request::$requestData;
        return header("Location: " . BASE_URL . $to);
    }

    public function to($toPath)
    {
        if ($toPath === CURRENT_URI) {
            return false;
        }
        $this->redirectTo($toPath);
    }

    public function back($to = null): Route
    {
        if (!$to) {
            unset($_SESSION["history3"][CURRENT_URI]);
            $to = end($_SESSION["history3"]);
        }
        $this->redirectTo($to);
        return $this;
    }

    public function with($with): Route
    {
        $_SESSION["tempSession"] = $with;
        return $this;
    }
}
