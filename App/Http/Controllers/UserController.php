<?php

namespace App\Http\Controllers;

use App\Http\Models\Role;
use App\Http\Models\User;
use App\Http\Services\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = Role::join('inner', 'users', 'roles.id = users.role_id')
            ->with('user')
            ->get()->data();
         return view('backend.users.list', compact('users'));
    }

    public function create()
    {
        return isLogged() ? view('backend.users.create'): view('auth.register');
    }

    public function store(Request $request)
    {
        $user = new User();
        extract($request->all());

        if ($password === $retype) {
            $user->role_id = 2;
            $user->email = $email;
            $user->username = $username;
            $user->unique_user = md5($username);
            $user->password = sha1(md5($password));
            $name = explode(' ', $request->name);

            $last = array_key_last($name);
            $lastName = $last > 0 ? $name[$last] : '';
            $firstName = $last > 0 ? explode($lastName, $request->name)[0] : $name[0];
            $user->f_name = $firstName;
            $user->l_name = $lastName;

            $action = $user->save();
            if ($action) {
                unset($action->password);
                $action->name = "{$action->f_name} {$action->l_name}";
                $action->{$user->role->role_slug} = true; // set guard

                $_SESSION['userInfo'] = (object) $action->store;
                $_SESSION['login'] = $action->unique_user;
                $_SESSION['login90'] = md5($action->email);
                return redirect()->back();
            }
        }
    }

    public static function changePassword()
    {
        return view('auth.change-password');
    }

    public static function passwordUpdate(Request $rq)
    {
        $user = $_SESSION['userInfo'];

        if (csrfCheck()) {
            if ($user->password !== sha1(md5($rq->current))) {
                $error = ['Wrong password' => 'Sorry! Your input current password is wrong. please insert correct password!'];
            }elseif ($rq->password !== $rq->retype) {
                $error = ['No match' => 'Sorry! Your new password and retype password is not match!'];
            }
        } else {
            $error = ['Don\'t try' => 'Wrong user!'];
        }

        if (empty($error)) {
            $result = User::where(['id' => $user->id])->update(['password' => sha1(md5($rq->password))]);

            if ($result) {
                $toastr = ['toastr' => ['success' => ['Password' =>
                "{$user->f_name} {$user->l_name} password is successfully updated."]]];
                return redirect('/')->with($toastr);
            } else {
                $toastr = ['error' => ['Failed' => 'Sorry! action failed, please retry.']];
                return redirect()->back()->with(['toastr' => $toastr]);
            }
        } else {
            return redirect()->back()->with(['error' => $error]);
        }
    }
}
