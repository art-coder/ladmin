<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Http\Requests\StorePermissionRequest;
use Artcoder\Ladmin\Repositories\BaseRepository;

class PermissionController extends Controller
{

    protected $permission = null;
    public $moduleName    = 'admin';

    public function __construct(BaseRepository $base)
    {
        parent::__construct();
        $this->permission = $base->model('Permission', 'Admin');
    }

    public function index()
    {
        $list = $this->permission->paginate(15);

        return view('admin::permission.index', compact('list'));
    }

    public function create(Request $request)
    {
        $page        = $request->input('page');
        $permission  = $this->permission->makeModel();
        $folder      = 'permission';
        $title       = '添加权限';
        $targetUrl   = route('admin.permission.index', ['page' => $page]);
        $targetTitle = '权限列表';
        $formUrl     = route('admin.permission.store', ['page' => $page]);

        return view('admin::partials.create', compact('permission', 'folder', 'title', 'formUrl', 'targetUrl', 'targetTitle'));
    }

    public function edit($id, Request $request)
    {
        $page        = $request->input('page');
        $folder      = 'permission';
        $title       = '权限管理';
        $subtitle    = '修改权限';
        $targetUrl   = route('admin.permission.index', ['page' => $page]);
        $targetTitle = '权限列表';
        $formUrl     = route('admin.permission.store', ['page' => $page]);
        $permission  = $this->permission->find($id);

        return view('admin::partials.edit',
            compact('permission', 'folder', 'title', 'subtitle', 'targetUrl', 'targetTitle', 'formUrl', 'id'));
    }

    public function store(StorePermissionRequest $request)
    {
        $page = $request->input('page');
        $id   = $request->input('id');
        if ($id) {
            $permission       = $this->permission->find($id);
            $permission->name = $request->name;
            $permission->info = $request->info;
            $permission->save();
        } else {
            $this->permission->create(['name' => $request->name, 'info' => $request->info]);
        }

        return redirect(route('admin.permission.index', ['page' => $page]))->withSuccess($id ? '修改成功！' : '添加成功！');
    }

    public function delete($id)
    {
        $permission = $this->permission->find($id);
        if (count($permission->roles)) {
            // delete roles permission
            foreach ($permission->roles as $role) {
                $role->pivot->delete();
            }
        }
        // delete permission
        $permission->delete();

        return redirect()->back()->withSuccess("删除权限#(" . $id . ")成功");
    }
}
