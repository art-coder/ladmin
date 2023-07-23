<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Repositories\BaseRepository;

class TestController extends Controller
{

    public $moduleName = 'test';

    public function index(Request $request, BaseRepository $base)
    {
        // $enabled = app('modules')->getOrdered();
        // $confs = [];
        // foreach ($enabled as $module) {
        //     $moduleName = $module->getName();
        //     dump($moduleName);
        //     // $configFile = $module->getPath($moduleName) . '/Config/config.php';
        //     // $conf = require($configFile);
        //     // $confs[$moduleName] = isset($conf['permissions']) ? $conf['permissions'] : null;
        // }

        $find = $base->repository('permission')->findWhere(['name' => 'create-user'])->first();
        dump($find);
    }
}
