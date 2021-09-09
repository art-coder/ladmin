<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Http\Requests\StoreUserRequest;
use Artcoder\Ladmin\Repositories\RoleRepository;
use Artcoder\Ladmin\Repositories\UserRepository;

class UserController extends Controller
{

    protected $user    = null;
    protected $role    = null;
    public $moduleName = 'admin';

    public function __construct(UserRepository $user, RoleRepository $role)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $list = $this->user->pagination(15);

        return view('admin::user.index', compact('list'));
    }

    public function create(Request $request)
    {
        $page        = $request->input('page');
        $folder      = 'user';
        $title       = '添加用户';
        $targetUrl   = route('admin.user.index', ['page' => $page]);
        $targetTitle = '用户列表';
        $formUrl     = route('admin.user.store', ['page' => $page]);
        $user        = $this->user->makeModel();
        $role        = $this->role->all();

        return view(
            'admin::partials.create',
            compact('user', 'role', 'folder', 'title', 'formUrl', 'targetUrl', 'targetTitle')
        );
    }

    public function edit($id, Request $request)
    {
        $page        = $request->input('page');
        $folder      = 'user';
        $title       = '修改用户';
        $targetUrl   = route('admin.user.index', ['page' => $page]);
        $targetTitle = '用户列表';
        $formUrl     = route('admin.user.store', ['page' => $page]);
        $user        = $this->user->find($id);
        $role        = $this->role->all();

        return view(
            'admin::partials.edit',
            compact('user', 'role', 'folder', 'title', 'targetUrl', 'targetTitle', 'formUrl', 'id')
        );
    }

    public function store(StoreUserRequest $request)
    {
        $page         = $request->input('page');
        $id           = $request->input('id');
        $roles        = $request->input('rids');
        $hasRoleCheck = $request->input('has_rids');
        $user         = $this->user->find($id);
        if ($id) {
            $pass = $request->input('password');
            $user->fill($request->except(['password', 'page', 'id', 'rids']));
            // change password
            if ($pass) {
                $user->password = bcrypt($pass);
            }
            $user->save();
            $redirectUrl = route('admin.user.index', ['page' => $page]);
        } else {
            $this->user->store($request, null, ['password' => bcrypt($request->input('password'))]);
            $redirectUrl = route('admin.user.index');
        }
        if ($hasRoleCheck) {
            $user->roles()->detach();
            $user->assignRole($roles);
        }

        return redirect($redirectUrl)->withSuccess($id ? '修改成功！' : '添加成功！');
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if (can_delete($user)) {
            $user->roles()->detach();
            $user->delete();
            return redirect()->back()->withSuccess("删除用户(#" . $id . " - " . $user->username . ")成功");
        } else {
            return redirect()->back()->withErrors("删除用户(#" . $id . " - " . $user->username . ")失败，当前用户不允许被删除");
        }
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        if ($keywords) {
            // $list = $this->user->search($keywords, 'username, phone, email', 15);
            $list = $this->user->search($keywords, ['username', 'phone', 'email'], 15);
        } else {
            $list = $this->user->pagination(15);
        }

        return view('admin::user.index', compact('list', 'keywords'));
    }
}
