<?php

namespace Artcoder\Ladmin\Entities;

trait MakeModel
{
    public function makeModel() {
        return $this->newInstance();
    }
}
