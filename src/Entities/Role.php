<?php

namespace Artcoder\Ladmin\Entities;

use Spatie\Permission\Models\Role as BaseModel;
use Artcoder\Ladmin\Libraries\Support\Traits\HasUnableDeletePK;

class Role extends BaseModel
{
    use HasUnableDeletePK;

    protected $fillable = [
        'name', 'info', 'guard_name',
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);
    }

}
