<?php

namespace App\Middleware;

use App\Http\Controllers\Auth;
use App\Http\Services\Request;
use App\Http\Services\RouteService;

class Authentication extends RouteService
{
    public function handle($middlewareGuard)
    {
        $guards = ['super-admin', 'admin', 'subscriber', 'client'];
        foreach ($guards as $guard) {
            if ($middlewareGuard === $guard && !Auth::isValidUser($guard)) {
                return URI !== '/login' ? redirect('/login'):false;
            }
        }
    }
}
