<?php

namespace Artcoder\Ladmin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Cache;

class Config extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'item', 'type', 'description', 'content',
    ];

    // protected static function newFactory()
    // {
    //     return \Artcoder\Ladmin\Database\factories\ConfigFactory::new();
    // }

    public function getList()
    {
        return Cache::store('file')->rememberForever('config', function () {
            return $this->all()->toArray();
        });
    }

    public function clearCache()
    {
        Cache::store('file')->forget('config');
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
