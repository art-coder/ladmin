<?php

namespace Artcoder\Ladmin\Http\Controllers\Api;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Http\Controllers\ApiController as Controller;
use Artcoder\Ladmin\Repositories\UserRepository;
use Hash;

class UserController extends Controller
{

    public function auth(Request $request, UserRepository $model)
    {
        $usernameVal = $request->input('username');
        if (filter_var($usernameVal, FILTER_VALIDATE_EMAIL) !== false) {
            $username = 'email';
        } else if (is_phone_number($usernameVal)) {
            $username = 'phone';
        } else {
            $username = 'username';
        }
        $user = $model->where([$username => $usernameVal, 'status' => 0])->first();
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $this->response['code'] = 0;
                $tokenName = $request->input('platform') ? $request->input('platform') : 'electron';
                $token = $user->createToken($tokenName);
                $this->response['data'] = $token->plainTextToken;
            } else {
                $this->response['code']     = 11000;
                $this->response['message']  = '用户名或密码错误';
            }
        } else {
            $this->response['code']     = 11000;
            $this->response['message']  = '用户名或密码错误';
        }
        return response()->json($this->response);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        if ($user && $user->status == 0) {
            $this->response['code'] = 0;
            $this->response['data'] = $user->toArray();
        } else {
            $this->response['code']     = 11001;
            $this->response['message']  = '未授权';
        }
        return response()->json($this->response);
    }
}
