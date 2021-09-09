<?php

namespace Artcoder\Ladmin\Repositories;

use Artcoder\Ladmin\Entities\Permission;

class PermissionRepository extends BaseRepository
{
    public function model()
    {
        return Permission::class;
    }

    public function group($checked = [])
    {
        // $items = config('permission.items');
        $items = $this->getModuleConfig('permissions');
        $lists = $this->all();
        // dump($lists->toArray());
        $permissions = $lists->pluck('id', 'name');
        // dump($permissions);
        foreach ($items as &$item) {
            foreach ($item['list'] as $key => &$value) {
                $pk = $item['name'] . '-' . $value['can'];
                // 去掉可能数据库不存在的权限元素
                if (!isset($permissions[$pk])) {
                    unset($item['list'][$key]);
                    continue;
                }
                // 添加id和checked元素
                $id               = $permissions[$pk];
                $value['id']      = $id;
                $value['checked'] = false;
                if ($checked) {
                    if (in_array($id, $checked)) {
                        $value['checked'] = true;
                    }
                }
            }
        }
        // dump($items);
        return $items;
    }

    public function getModuleConfig($item)
    {
        $modules = app('modules')->getOrdered();
        $list    = [];
        foreach ($modules as $module) {
            $name        = $module->getLowerName();
            $list[$name] = config($name . '.' . $item);
        }
        $res = [];
        foreach ($list as $value) {
            if ($value) {
                foreach ($value as $key => $val) {
                    if (is_numeric($key)) {
                        $res[] = $val;
                    } else {
                        $res[$key] = $val;
                    }
                }
            }
        }
        return $res;
    }
}
