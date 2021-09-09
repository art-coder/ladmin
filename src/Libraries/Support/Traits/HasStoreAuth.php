<?php

namespace Artcoder\Ladmin\Libraries\Support\Traits;

trait HasStoreAuth
{

    public function canUpdateRoles()
    {
        return is_admin_group(auth()->user());
    }

    public function canUpdateSuperAdmin()
    {
        return auth()->user()->is_super_admin;
    }
}
