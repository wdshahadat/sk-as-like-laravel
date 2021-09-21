<?php

namespace App\Http\Controllers;

// use App\Config\Content;
use App\Http\Models\User;
use App\Http\Services\Request;
use App\Http\Controllers\Controller;

class Auth extends Controller
{
    private static $user;

    public function loginCheck()
    {
        if (!isset($_SESSION['login90'])) {
            return redirect('login');
        }
    }

    public function userAuth($request)
    {
        $user = User::find(['email' => $request->email]);

        if ($user) {
            if ($user->password === sha1(md5($request->password))) {
                $user->name = "{$user->f_name} {$user->l_name}";
                $user->{$user->role->role_slug} = true;

                $_SESSION['userInfo'] = (object) $user->store;
                $_SESSION['login90'] = md5($request->email);
                $_SESSION['login'] = $user->unique_user;
                return redirect('/');
            } else {
                $error = ['Invalid' => 'Invalid password!'];
            }
        } else {
            $error = ['Invalid User' => 'User is not exists'];
        }

        if (isset($error)) {
            return redirect('/login')->with(['toastr' => ['error' => $error]]);
        }
    }

    public function login()
    {
        if (isset($_SESSION['login'])) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public static function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public static function forgotPasswordSendEmail(Request $request)
    {
        $user = User::find(['email' => $request->email]);
        return $user;
    }

    public static function routes()
    {
        return new Auth;
    }

    public static function logOut()
    {
        session_destroy();
        return redirect('login');
    }

    public static function user($id)
    {
        $user = isset(self::$user) ? self::$user : null;

        if ($id) {
            $user = User::find($id);
            $user->name = "{$user->f_name} {$user->l_name}";
            self::$user = $user;
        }

        $user = !is_object($user) && isset($_SESSION['userInfo']) ? $_SESSION['userInfo'] : $user;
        return $user ? $user : (object) [];
    }

    public static function isValidUser($userType = '')
    {
        if (!self::isLogged()) {
            return false;
        }
        return isset($_SESSION['userInfo']) && isset($_SESSION['userInfo']->{$userType}) ? true : false;
    }

    public static function isLogged()
    {
        return isset($_SESSION['login90']) && $_SESSION['login90'] === md5($_SESSION['userInfo']->email) ? true : false;
    }
}
