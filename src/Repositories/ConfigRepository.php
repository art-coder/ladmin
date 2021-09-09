<?php

namespace Artcoder\Ladmin\Repositories;

use Artcoder\Ladmin\Entities\Config;

class ConfigRepository extends BaseRepository
{
    public function model()
    {
        return Config::class;
    }

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
