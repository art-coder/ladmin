<?php

namespace Artcoder\Ladmin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Artcoder\Ladmin\Libraries\Support\Traits\HasStatus;
use Artcoder\Ladmin\Libraries\Support\Traits\HasStoreAuth;
use Artcoder\Ladmin\Libraries\Support\Traits\HasUnableDeletePK;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use MakeModel, HasApiTokens, HasFactory, Notifiable,
    HasRoles, HasStatus, HasUnableDeletePK, HasStoreAuth;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'username',
        'phone',
        'email',
        'password',
        'is_super_admin',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $statusType = 'user';

    public function roleExhibition()
    {
        if ($this->is_super_admin) {
            return '超级管理员';
        } else {
            $roles = $this->getRoleNames()->toArray();
            if ($roles) {
                return implode(' - ', $roles);
            } else {
                return '游客';
            }
        }
    }

    protected static function newFactory()
    {
        return new \Artcoder\Ladmin\Database\factories\UserFactory;
    }

    // based on https://github.com/AsgardCms/Platform/blob/3.0/Modules/User/Entities/Sentinel/User.php#L108-L123
    public function __get($key)
    {
        // $res = $this->getAttribute($key);
        $res = parent::__get($key);
        if ($res === null && !in_array($key, $this->fillable)) {
            $modules           = app('modules')->allEnabled();
            $activeModuleNames = [];
            foreach ($modules as $module) {
                array_push($activeModuleNames, $module->getLowerName());
            }
            foreach ($activeModuleNames as $name) {
                $config = implode('.', [$name, 'relations.user', $key]);
                if (config()->has($config)) {
                    $function = config()->get($config);
                    $bound    = $function->bindTo($this);
                    return $bound()->get();
                }
            }
        }
        return $res;
    }

    // based on https://github.com/AsgardCms/Platform/blob/3.0/Modules/User/Entities/Sentinel/User.php#L108-L123
    public function __call($method, $parameters)
    {
        // get actives module
        $modules           = app('modules')->allEnabled();
        $activeModuleNames = [];
        foreach ($modules as $key => $module) {
            array_push($activeModuleNames, $module->getLowerName());
        }
        foreach ($activeModuleNames as $key => $name) {
            $config = implode('.', [$name, 'relations.user', $method]);
            if (config()->has($config)) {
                $function = config()->get($config);
                $bound    = $function->bindTo($this);
                return $bound(...$parameters);
            }
        }
        return parent::__call($method, $parameters);
    }
}
