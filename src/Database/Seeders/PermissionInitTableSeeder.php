<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Artcoder\Ladmin\Repositories\PermissionRepository;
use Artcoder\Ladmin\Repositories\RoleRepository;
use Artcoder\Ladmin\Repositories\UserRepository;

class PermissionInitTableSeeder extends Seeder
{
    public function __construct(PermissionRepository $permission, RoleRepository $role, UserRepository $user)
    {
        $this->permission = $permission;
        $this->role = $role;
        $this->user = $user;
    }

    public function run()
    {
        $conf = require(__DIR__ . '/../../Config/config.php');
        $config = isset($conf['permissions']) ? $conf['permissions'] : null;
        $rootIds = $editorIds = [];
        if ($config) {
            foreach ($config as $items) {
                foreach ($items['list'] as $value) {
                    $name = $items['name'] . '-' . $value['can'];
                    $one  = $this->permission->findWhere(['name' => $name])->first();
                    if ($one) {
                        if ($one->info != $value['name']) {
                            $one->info = $value['name'];
                            $one->save();
                        }
                    } else {
                        $one = $this->permission->create([
                            'name'       => $name,
                            'info'       => $value['name'],
                            'guard_name' => 'web',
                        ]);
                    }
                    array_push($rootIds, $one->id);
                    if ($value['can'] == 'index' || $value['can'] == 'list') {
                        array_push($editorIds, $one->id);
                    }
                }
            }
        }

        // ===> add roler
        $rootName = '管理员';
        $root = $this->role->findWhere(['name' => $rootName])->first();
        if (!$root) {
            $root = $this->role->create([
                'name'       => $rootName,
                'guard_name' => 'web',
            ]);
        }
        // $root->syncPermissions($rootIds);
        $root->givePermissionTo($rootIds);

        $editorName = '编辑员';
        $editor = $this->role->findWhere(['name' => $editorName])->first();
        if (!$editor) {
            $editor = $this->role->create([
                'name'       => '编辑员',
                'guard_name' => 'web',
            ]);
        }
        // $editor->syncPermissions($editorIds);
        $editor->givePermissionTo($editorIds);

        $isDev = app()->environment() !== 'production';
        if ($isDev) {
            $user = $this->user->find(2);
            $user->assignRole([2]);
        }
    }
}
