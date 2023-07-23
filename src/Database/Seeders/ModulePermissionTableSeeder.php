<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Artcoder\Ladmin\Repositories\BaseRepository;

class ModulePermissionTableSeeder extends Seeder
{

    protected $rep = null;

    public function __construct(BaseRepository $rep)
    {
        $this->rep = $rep;
    }

    public function run(...$params){
        if (!$params) return ;
        foreach ($params as $name) {
            $this->handelPermission($name);
        }
    }

    public function handelPermission($module_name)
    {
        $module      = app('modules')->find($module_name);
        $moduleName  = $module->getName(); // 不包含后台core
        $configFile  = $module->getPath($moduleName) . '/Config/config.php';
        $conf        = require($configFile);
        $permissions = isset($conf['permissions']) ? $conf['permissions'] : null;
        if ($permissions) {
            foreach ($permissions as $items) {
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
                }
            }
        }
    }
}
