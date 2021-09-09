<?php

namespace Artcoder\Ladmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'email'    => 'required|email',
            'phone'    => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'username' => '昵称',
            'email'    => '邮箱',
            'phone'    => '电话',
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
