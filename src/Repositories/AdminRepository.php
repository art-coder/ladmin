<?php

namespace Artcoder\Ladmin\Repositories;

use Artcoder\Ladmin\Entities\Permission;

class AdminRepository extends BaseRepository
{

    public function group($checked = [])
    {
        // $items = config('permission.items');
        $items = $this->getModuleConfig('permissions');
        // $lists = $this->all();
        $lists = Permission::all();
        // dump($lists->toArray());
        $permissions = $lists->pluck('id', 'name')->toArray();
        $handel_permissions = [];
        // dump($permissions);
        foreach ($items as &$item) {
            foreach ($item['list'] as $key => &$value) {
                $pk = $item['name'] . '-' . $value['can'];
                // 去掉可能数据库不存在的权限元素
                if (!isset($permissions[$pk])) {
                    unset($item['list'][$key]);
                    continue;
                }
                array_push($handel_permissions, $pk);
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
        $diff = array_diff(array_keys($permissions), $handel_permissions);
        if ($diff) {
            $values = $lists->keyBy('name')->toArray();
            $list  = [];
            foreach ($diff as $temp) {
                array_push($list, [
                    "route"   => null,
                    "can"     => $values[$temp]['name'],
                    "name"    => $values[$temp]['info'],
                    "id"      => $values[$temp]['id'],
                    "checked" => in_array($values[$temp]['id'], $checked)
                ]);
            }
            $items[] = [
                'name' => 'single',
                'title' => '单项控制',
                'list' => $list
            ];
        }
        // dump($items);
        return $items;
    }

    public function getModuleConfig($item)
    {
        $modules = app('modules')->getOrdered();
        $list    = [];
        if (!isset($modules['Admin'])) array_unshift($modules, app('admin')); // $modules['Admin'] = app('admin');
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

    public function info($index = '')
    {
        if ($index) {
            return $this->model('Config', 'Admin')->getItem($index);
        } else {
            return $this->model('Config', 'Admin')->getList();
        }
    }

    public function pluckInfo()
    {
        $list = $this->info();
        return array_pluck($list, 'content', 'item');
    }

    public function clearCache()
    {
        return $this->model('Config', 'Admin')->clearCache();
    }

}
