<?php

namespace Artcoder\Ladmin\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use Artcoder\Ladmin\Repositories\AdminRepository;

class Admin
{

    protected $excepts    = [];
    protected $permission = null;
    protected $role       = null;
    protected $adminGroup = 1; // role id is 1

    public function __construct(Gate $gate, AdminRepository $admin)
    {
        $this->permission = $admin->builder('Permission', 'Admin');
        $this->role       = $admin->builder('Role', 'Admin');
        $this->excepts    = $admin->getModuleConfig('excepts');
        $this->gate       = $gate;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = Auth::user();
        // not login
        if (!$user) {
            return redirect(route('admin.login'));
        }

        // super admin and admin group
        if (is_admin_group($user)) {
            return $next($request);
        }

        // except
        $name = $request->route()->getName();
        if (in_array($name, $this->excepts)) {
            return $next($request);
        }

        // has permission
        $enabled = app('modules')->getOrdered();
        $confs = [];
        foreach ($enabled as $module) {
            $moduleName = $module->getName();
            $configFile = $module->getPath($moduleName) . '/Config/config.php';
            $conf = require($configFile);
            $confs[$moduleName] = isset($conf['permissions']) ? $conf['permissions'] : null;
        }

        $ladminConfig = require(__DIR__  . '/../../Config/config.php');
        $confs['Ladmin'] = $ladminConfig['permissions'];

        $permissions = [];
        foreach ($confs as $moduleName => $list) {
            foreach ($list as $item) {
                foreach ($item['list'] as $value) {
                    $permissions[$value['route']] = $item['name'] . '-' . $value['can'];
                }
            }
        }
        $permission = isset($permissions[$name]) ? $permissions[$name] : null; // system-index
        $isAjax     = $request->ajax();
        if ($permission) {
            if ($this->gate->allows($permission)) {
                return $next($request);
            } else {
                if ($isAjax) {
                    return $this->ajaxPostResponse(403, '您没有权限执行此操作！！！');
                } else {
                    return abort(403, '未授权操作');
                }
            }
        } else {
            $belongs = $this->permission->getModuleConfig('belongs');
            // 还需要添加ladmin中的belongs
            if (isset($belongs[$name])) {
                if ($this->gate->any($belongs[$name])) {
                    return $next($request);
                } else {
                    if ($isAjax) {
                        return $this->ajaxPostResponse(403, '您没有权限执行此操作！！！');
                    } else {
                        return abort(403, '未授权操作');
                    }
                }
            }
        }
        return $next($request);
    }

    protected function ajaxPostResponse($code = 404, $msg = 'error params')
    {
        return response()->json([
            'code'   => $code,
            'msg'    => $msg,
        ]);
    }
}
