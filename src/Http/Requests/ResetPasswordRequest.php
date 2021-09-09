<?php

namespace Artcoder\Ladmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Artcoder\Ladmin\Rules\CheckPassword;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_pwd'               => ['required', new CheckPassword()],
            'password'              => 'required|between:6,20|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'old_pwd'               => '旧密码',
            'password'              => '新密码',
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
