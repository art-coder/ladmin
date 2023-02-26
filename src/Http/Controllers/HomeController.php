<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;

// SessionGuard 处理用户登录事宜

class HomeController extends Controller
{
    public function index()
    {
        return view('admin::home.index');
    }

    public function login(Request $request)
    {
        return view('admin::home.login');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect(route('admin.login'));
    }

    public function pl(Request $request)
    {
        $usernameVal = $request->input('username');
        if (filter_var($usernameVal, FILTER_VALIDATE_EMAIL) !== false) {
            $username = 'email';
        } else if (is_phone_number($usernameVal)) {
            $username = 'phone';
        } else {
            $username = 'username';
        }
        $data = [
            $username  => $usernameVal,
            'password' => $request->input('password'),
            'status'   => 0,// 0才是正常的，其他的都不正常
        ];
        auth()->attempt($data, $request->input('remember') ? true : false);
        return redirect(route('admin.home.index'));
    }
}
