<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Http\Requests\StoreRoleRequest;
use Artcoder\Ladmin\Repositories\AdminRepository;

class RoleController extends Controller
{

    protected $permission = null;
    protected $role       = null;
    public $moduleName    = 'admin';

    public function __construct(AdminRepository $base)
    {
        parent::__construct();
        $this->permission = $base->repository('Permission', 'Admin');
        $this->role       = $base->model('Role', 'Admin');
    }

    public function index()
    {
        $list = $this->role->paginate(15);

        return view('admin::role.index', compact('list'));
    }

    public function create(Request $request)
    {
        $page        = $request->input('page');
        $folder      = 'role';
        $title       = '添加角色';
        $targetUrl   = route('admin.role.index', ['page' => $page]);
        $targetTitle = '角色列表';
        $formUrl     = route('admin.role.store', ['page' => $page]);
        $permission  = $this->permission->group();
        $role        = $this->role->makeModel();

        return view(
            'admin::partials.create',
            compact('permission', 'role', 'folder', 'title', 'targetUrl', 'targetTitle', 'formUrl')
        );
    }

    public function edit($id, Request $request)
    {
        $page        = $request->input('page');
        $folder      = 'role';
        $title       = '修改角色';
        $targetUrl   = route('admin.role.index', ['page' => $page]);
        $targetTitle = '角色列表';
        $formUrl     = route('admin.role.store', ['page' => $page]);
        $role        = $this->role->find($id);
        $permission  = $this->permission->group($role->permissions->pluck('id')->toArray());

        return view(
            'admin::partials.edit',
            compact('permission', 'role', 'folder', 'title', 'targetUrl', 'id', 'targetTitle', 'formUrl')
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $id          = $request->input('id');
        $page        = $request->input('page');
        $permissions = $request->input('pids');
        if ($id) {
            $role       = $this->role->find($id);
            $role->name = $request->name;
            $role->save();
            if ($permissions) {
                $role->syncPermissions($permissions);
            }
        } else {
            $role = $this->role->create(['name' => $request->name]);
            if ($permissions) {
                $role->syncPermissions($permissions);
            }
        }

        return redirect(route('admin.role.index', ['page' => $page]))->withSuccess($id ? '修改成功！' : '添加成功！');
    }

    public function delete($id)
    {
        $role = $this->role->find($id);

        if (can_delete($role)) {
            $role->permissions()->detach();
            $role->delete();
            return redirect()->back()->withSuccess("删除角色(#" . $id . ")成功");
        } else {
            return redirect()->back()->withErrors("删除角色(#" . $id . ")失败，当前角色不允许被删除");
        }
    }
}
