<?php

namespace Artcoder\Ladmin\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{

    public function scopeSorted($query, $type = 'desc')
    {
        return $query->orderBy('sort', $type);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function scopeWithoutTimestamps()
    {
        $this->timestamps = false;
        return $this;
    }

}
