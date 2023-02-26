<?php

namespace Artcoder\Ladmin\Components;

use Illuminate\View\Component;

class Menu extends Component
{

    protected $menus = [];

    public function __construct()
    {
        $menus = $this->getModuleMenus();
        array_unshift($menus, $this->getLadminMenus());
        $this->menus = $this->filter($menus);
    }

    protected function getLadminMenus()
    {
        $menus = [];
        $conf  = require(__DIR__ . '/../Config/config.php');
        $menus = $conf['menus'];
        return $menus;
    }

    protected function getModuleMenus()
    {
        $enabled = app('modules')->getOrdered();
        $menus   = [];
        foreach ($enabled as $key => $module) {
            $name = $module->getName();
            // $menus[$name] = config($name . '.menus');
            // 只能使用require方式，原因是在appservice boot 中，config还没有读取到module的配置
            $configFile = $module->getPath($name) . '/Config/config.php';
            $conf = require($configFile);
            $menus[$name] = isset($conf['menus']) ? $conf['menus'] : null;
        }
        return $menus;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin::components.menu', ['menus' => $this->menus]);
    }

    protected function filter($menus)
    {
        $user = auth()->user();
        if (is_super_admin($user)) {
            return $menus;
        }
        foreach ($menus as $name => $item) {
            foreach ($item as $key => $value) {
                if (isset($value['submenu'])) {
                    foreach ($value['submenu'] as $k => $val) {
                        if (!$user->can($val['can'])) {
                            unset($menus[$name][$key]['submenu'][$k]);
                        }
                    }
                }
            }
        }
        foreach ($menus as $name => $item) {
            foreach ($item as $key => $value) {
                if (!$value['submenu'] && !isset($value['route'])) {
                    unset($menus[$name][$key]);
                }
            }
        }
        return $menus;
    }
}
