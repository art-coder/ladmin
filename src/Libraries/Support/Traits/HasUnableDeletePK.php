<?php

namespace Artcoder\Ladmin\Libraries\Support\Traits;

trait HasUnableDeletePK
{

    public function canDeletePK()
    {
        $this->getUnableId();
        return !in_array($this->id, $this->unableIdValue);
    }

    protected function getUnableId()
    {
        if (!$this->unableIdValue) {
            $this->unableIdValue = [1];
        }
    }
}
