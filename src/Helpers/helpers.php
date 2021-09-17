<?php

use Illuminate\Support\Facades\Route;


if (!function_exists('diffBetweenTwoDays')) {
    function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }
}

if (!function_exists('get_modules_ordered')) {
    function get_modules_ordered()
    {
        return array_merge(['Admin' => app('admin')], app('modules')->getOrdered());
    }
}

if (!function_exists('get_module_config')) {
    function get_module_config($item = '', $module = 'admin', $file = 'config')
    {
        $module = ucfirst($module);
        if ($module == 'Admin') {
            $path = __DIR__ . '/../Config/' . $file . '.php';
            $arrs = require $path;
            if ($item) {
                return $arrs[$item];
            } else {
                return $arrs;
            }
        } else {
            $path = module_path($module) . '/Config/' . $file . '.php';
            $arrs = require $path;
            if ($item) {
                return $arrs[$item];
            } else {
                return $arrs;
            }
        }
    }
}

if (!function_exists('route_list')) {
    function route_list($name, $module = null)
    {
        if ($module) {
            Route::get($module . '/' . $name, ucfirst($name) . 'Controller@index')->name($module . '.' . $name . '.index');
            Route::get($module . '/' . $name . '/create', ucfirst($name) . 'Controller@create')->name($module . '.' . $name . '.create');
            Route::get($module . '/' . $name . '/edit/{id}', ucfirst($name) . 'Controller@edit')->name($module . '.' . $name . '.edit');
            Route::post($module . '/' . $name . '/store', ucfirst($name) . 'Controller@store')->name($module . '.' . $name . '.store');
            Route::get($module . '/' . $name . '/delete/{id}', ucfirst($name) . 'Controller@delete')->name($module . '.' . $name . '.delete');
        } else {
            Route::get($name . '/index', ucfirst($name) . 'Controller@index')->name($name . '.index');
            Route::get($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
            Route::get($name . '/edit/{id}', ucfirst($name) . 'Controller@edit')->name($name . '.edit');
            Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');
            Route::get($name . '/delete/{id}', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
        }
    }
}

if (!function_exists('is_phone_number')) {
    function is_phone_number($phonenumber)
    {
        return preg_match("/^1[34578]{1}\d{9}$/", $phonenumber);
    }
}

if (!function_exists('start_with')) {
    function start_with($str, $pattern)
    {
        return strpos($str, $pattern) === 0 ? true : false;
    }
}

if (!function_exists('can_delete')) {
    function can_delete($model)
    {
        if (method_exists($model, 'canDeletePK')) {
            return $model->canDeletePK();
        } else {
            return true;
        }
    }
}

if (!function_exists('is_super_admin')) {
    function is_super_admin($user)
    {
        return $user->is_super_admin;
    }
}

if (!function_exists('is_admin_group')) {
    function is_admin_group($user)
    {
        if (is_super_admin($user)) {
            return true;
        }
        if ($user->hasRole(1)) {
            // dump(2222);
            return true;
        }
        return false;
    }
}

if (!function_exists('has_permission')) {
    function has_permission($user, $permission)
    {
        if (is_admin_group($user)) {
            return true;
        }
        return $user->can($permission);
    }
}

if (!function_exists('display_notification')) {
    function display_notification($notification)
    {
        return ('\\' . $notification->type)::notice($notification);
    }
}

if (!function_exists('get_guid')) {
    function get_guid()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid   = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }
}

if (!function_exists('short_hash')) {
    function short_hash($input)
    {
        $key  = config('app.key'); //加盐
        $hash = md5($key . $input);
        $len  = strlen($hash);
        // $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $charset = "23456789ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz98765432";
        //将加密后的串分成4段，每段4字节，对每段进行计算，一共可以生成四组短连接
        for ($i = 0; $i < 4; $i++) {
            $hash_piece = substr($hash, $i * $len / 4, $len / 4);
            //将分段的位与0x3fffffff做位与，0x3fffffff表示二进制数的30个1，即30位以后的加密串都归零
            //此处需要用到hexdec()将16进制字符串转为10进制数值型，否则运算会不正常
            $hex        = hexdec($hash_piece) & 0x3fffffff;
            $short_hash = "";
            //生成6位短网址
            for ($j = 0; $j < 6; $j++) {
                //将得到的值与0x0000003d,3d为61，即charset的坐标最大值
                $short_hash .= $charset[$hex & 0x0000003d];
                //循环完以后将hex右移5位
                $hex = $hex >> 5;
            }
            $short_hash_list[] = $short_hash;
        }
        return $short_hash_list;
    }
}

if (!function_exists('handle_params_string')) {
    function handle_params_string($string)
    {
        $paramsStringArr = explode("\r\n", $string);
        $params          = [];
        foreach ($paramsStringArr as $paramsString) {
            $temp = explode("=", $paramsString);
            if ($temp[0]) {
                $params[$temp[0]] = isset($temp[1]) ? $temp[1] : '';
            }
        }
        return $params;
    }
}

if (!function_exists('echo_class_error')) {
    function echo_class_error($errors, $value)
    {
        return $errors->has($value) ? 'has-error' : '';
    }
}

if (!function_exists('echo_error')) {
    function echo_error($errors, $value)
    {
        if ($errors->has($value)) {
            return '<span class="error help-block">' . $errors->first($value) . '</span>';
        }
        return '';
    }
}

if (!function_exists('run_relation')) {
    function run_relation($module, $model, $file)
    {
        return function (...$parameters) use ($module, $model, $file) {
            $path = app('modules')->find($module)->getPath() . '/Relations/' . ucfirst($model) . '/' . $file . '.php';
            if (file_exists($path)) {
                return (require $path)(...$parameters);
            } else {
                $module = ucfirst($module);
                throw new \ErrorException("The <$module> module does not exist relation <$file.php> file");
            }
        };
    }
}

if (!function_exists('active_menu')) {
    function active_menu($menu)
    {
        $now = request()->route()->getName();
        if ($menu['route'] == $now || (isset($menu['activeRoutes']) && in_array($now, $menu['activeRoutes']))) {
            return 'active';
        } else {
            return '';
        }
    }
}

if (!function_exists('operation_hints')) {
    function operation_hints($module, $key)
    {
        $cookie = request()->cookie('hints');
        if ($cookie) {
            $cookie = json_decode($cookie, true);
        }
        if (isset($cookie[$module]) && isset($cookie[$module][$key]) && $cookie[$module][$key] == false) {
            return '';
        }
        if ($module == 'admin') {
            $path = __DIR__ . '/../Config/hints.php';
        } else {
            $path = app('modules')->find($module)->getPath() . '/Config/hints.php';
        }
        if (file_exists($path)) {
            $hintsArr = require $path;
            $hints    = isset($hintsArr[$key]) ? $hintsArr[$key] : false;
            if ($hints) {
                $liStr = join('', array_map(function ($item) {
                    return "<li>{$item}</li>";
                }, $hints['items']));
                return <<<HTML
<div class="alert alert-{$hints['type']} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-info"></i> {$hints['title']}</h4>
    <ol>
        {$liStr}
    </ol>
</div>
HTML;
            }
        }
        return '';
    }
}
