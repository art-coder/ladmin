<?php

namespace Artcoder\Ladmin\Libraries\Support\Traits;

trait HasConfigRepository
{

    public function info($index = '')
    {
        if ($index) {
            return $this->model->getItem($index);
        } else {
            return $this->model->getList();
        }
    }

    public function pluckInfo()
    {
        $list = $this->info();
        return array_pluck($list, 'content', 'item');
    }

    public function clearCache()
    {
        return $this->model->clearCache();
    }
}
