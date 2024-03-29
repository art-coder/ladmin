<?php

namespace Artcoder\Ladmin\Entities;
use Spatie\Permission\Models\Permission as PPermission;

class Permission extends PPermission
{

    use MakeModel;

    protected $fillable = [
        'name', 'info', 'guard_name',
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);
    }

}
