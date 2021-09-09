<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Artcoder\Ladmin\Repositories\PermissionRepository;
use Artcoder\Ladmin\Repositories\RoleRepository;
use Artcoder\Ladmin\Repositories\UserRepository;

class PermissionTableSeeder extends Seeder
{
    public function __construct(PermissionRepository $permission, RoleRepository $role, UserRepository $user)
    {
        $this->permission = $permission;
        $this->role = $role;
        $this->user = $user;
    }

    public function run()
    {
        // $enabled = app('modules')->getOrdered();
        $confs = [];
        // foreach ($enabled as $module) {
        //     $moduleName = $module->getName();
        //     $configFile = $module->getPath($moduleName) . '/Config/config.php';
        //     $conf = require($configFile);
        //     $confs[$moduleName] = isset($conf['permissions']) ? $conf['permissions'] : null;
        // }
        // dump(realpath(__DIR__ . '/../../Config/config.php'));
        $conf = require(__DIR__ . '/../../Config/config.php');
        $confs['core'] = isset($conf['permissions']) ? $conf['permissions'] : null;
        // dump($confs);
        $rootIds = $editorIds = [];
        foreach ($confs as $modulePermissions) {
            if ($modulePermissions) {
                foreach ($modulePermissions as $items) {
                    foreach ($items['list'] as $value) {
                        $name = $items['name'] . '-' . $value['can'];
                        $find = $this->permission->findWhere(['name' => $name])->first();
                        dump($find);
                        // if ($find) {
                        //     array_push($rootIds, $find->id);
                        //     if ($value['can'] == 'index' || $value['can'] == 'list') {
                        //         array_push($editorIds, $find->id);
                        //     }
                        // }
                    }
                }
            }
        }

        // // add roler

        // $rootName = '管理员';
        // $root = $this->role->findWhere(['name' => $rootName])->first();
        // if (!$root) {
        //     $root = $this->role->create([
        //         'name'       => $rootName,
        //         'guard_name' => 'web',
        //     ]);
        // }
        // // $root->syncPermissions($rootIds);
        // $root->givePermissionTo($rootIds);

        // $editorName = '编辑员';
        // $editor = $this->role->findWhere(['name' => $editorName])->first();
        // if (!$editor) {
        //     $editor = $this->role->create([
        //         'name'       => '编辑员',
        //         'guard_name' => 'web',
        //     ]);
        // }
        // // $editor->syncPermissions($editorIds);
        // $editor->givePermissionTo($editorIds);

        // $isDev = app()->environment() !== 'production';
        // if ($isDev) {
        //     $user = $this->user->find(2);
        //     $user->assignRole([2]);
        // }
    }
}
