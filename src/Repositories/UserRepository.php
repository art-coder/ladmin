<?php

namespace Artcoder\Ladmin\Repositories;

use Artcoder\Ladmin\Entities\User;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

}
