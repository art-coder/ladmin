<?php

namespace Artcoder\Ladmin\Libraries\Support\Traits;

use Cache;

trait HasConfig
{

    public function getList()
    {
        return Cache::store('file')->rememberForever($this->cacheKey, function () {
            return $this->all()->toArray();
        });
    }

    public function clearCache()
    {
        Cache::store('file')->forget($this->cacheKey);
    }

    public function getItem($index, $defalt = false)
    {
        $list = $this->getList();
        foreach ($list as $value) {
            if ($value['item'] == $index) {
                return $value['content'];
            }
        }
        return $defalt;
    }
}
