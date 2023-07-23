<?php

namespace Artcoder\Ladmin\Entities;

use Artcoder\Ladmin\Libraries\Support\Traits\HasUnableDeletePK;
use Spatie\Permission\Models\Role as PRole;

class Role extends PRole
{
    use HasUnableDeletePK, MakeModel;

    protected $fillable = [
        'name', 'info', 'guard_name',
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);
    }

}
