<?php

namespace Artcoder\Ladmin\Repositories;

use Artcoder\Ladmin\Entities\Role;

class RoleRepository extends BaseRepository
{
    public function model()
    {
        return Role::class;
    }
}
