<?php

namespace Artcoder\Ladmin\Rules;

use Auth;
use DB;
use Hash;
use Illuminate\Contracts\Validation\Rule;

class CheckPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Auth::user();
        $res  = DB::table('users')->where('id', $user->id)->select('password')->first();
        return Hash::check($value, $res->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '旧密码不匹配.';
    }
}
