<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Artcoder\Ladmin\Repositories\BaseRepository;

class PermissionInitTableSeeder extends Seeder
{

    protected $rep = null;

    public function __construct(BaseRepository $rep)
    {
        $this->rep = $rep;
    }

    public function run()
    {
        $conf    = require(__DIR__ . '/../../Config/config.php');
        $config  = isset($conf['permissions']) ? $conf['permissions'] : null;
        $rootIds = $editorIds = [];
        if ($config) {
            foreach ($config as $items) {
                foreach ($items['list'] as $value) {
                    $name = $items['name'] . '-' . $value['can'];
                    $one  = $this->rep->repository('permission')->findWhere(['name' => $name])->first();
                    if ($one) {
                        if ($one->info != $value['name']) {
                            $one->info = $value['name'];
                            $one->save();
                        }
                    } else {
                        $one = $this->rep->model('permission')->create([
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
        $root = $this->rep->repository('role')->findWhere(['name' => $rootName])->first();
        if (!$root) {
            $root = $this->rep->model('role')->create([
                'name'       => $rootName,
                'guard_name' => 'web',
            ]);
        }
        // $root->syncPermissions($rootIds);
        $root->givePermissionTo($rootIds);

        $editorName = '编辑员';
        $editor = $this->rep->repository('role')->findWhere(['name' => $editorName])->first();
        if (!$editor) {
            $editor = $this->rep->model('role')->create([
                'name'       => '编辑员',
                'guard_name' => 'web',
            ]);
        }
        // $editor->syncPermissions($editorIds);
        $editor->givePermissionTo($editorIds);

        $isDev = app()->environment() !== 'production';
        if ($isDev) {
            $user = $this->rep->model('user')->find(2);
            $user->assignRole([2]);
        }
    }
}
