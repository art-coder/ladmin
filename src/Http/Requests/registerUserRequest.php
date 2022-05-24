<?php

namespace Artcoder\Ladmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'              => 'required|unique:users',
            'email'                 => 'required|email|unique:users',
            'phone'                 => 'required|unique:users',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'username'              => '昵称',
            'email'                 => '邮箱',
            'phone'                 => '电话',
            'password'              => '密码',
            'password_confirmation' => '确认密码',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
