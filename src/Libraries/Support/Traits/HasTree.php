<?php

namespace Artcoder\Ladmin\Libraries\Support\Traits;

trait HasTree
{
    public function child()
    {
        // return $this->hasMany(__CLASS__, 'pid', 'id')->sorted();
        return $this->hasMany(__CLASS__, 'pid', 'id');
    }

    public function children()
    {
        // return $this->child()->with('children')->sorted();
        return $this->child()->with('children');
    }
}
