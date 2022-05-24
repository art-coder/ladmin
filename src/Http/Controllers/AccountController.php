<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Repositories\UserRepository;
use Artcoder\Ladmin\Http\Requests\RegisterUserRequest;

// SessionGuard 处理用户登录事宜
// 同Homecontroller逻辑一样，目的是不暴露后台url，并且前后端分离

class AccountController extends Controller
{

    public function login(Request $request)
    {
        return view('admin::account.login');
    }

    public function register(Request $request)
    {
        return view('admin::account.register');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $redirect_url = $request->input('redirect_url') ? $request->input('redirect_url') : '/';
        return redirect($redirect_url);
    }

    public function loginPost(Request $request)
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
            $username => $usernameVal,
            'password' => $request->input('password'),
            'status' => 0, // 0才是正常的，其他的都不正常
        ];
        auth()->attempt($data, $request->input('remember') ? true : false);
        $redirect_url = $request->input('redirect_url') ? $request->input('redirect_url') : '/';
        return redirect($redirect_url);
    }

    // 完成用户注册以及验证功能
    public function registerPost(RegisterUserRequest $request, UserRepository $user)
    {
        $user->create([
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'phone'    => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
        ]);
        // $user->store($request, null, ['password' => bcrypt($request->input('password'))]);
        // bug, password
        $redirect_url = $request->input('redirect_url') ? $request->input('redirect_url') : '/';
        return redirect($redirect_url);
    }
}
