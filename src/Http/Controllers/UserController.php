<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Http\Requests\StoreUserRequest;
use Artcoder\Ladmin\Repositories\AdminRepository;

class UserController extends Controller
{

    public $moduleName = 'admin';

    public function index(Request $request, AdminRepository $rep)
    {
        $list = $rep->model('User')->paginate(15);

        return view('admin::user.index', compact('list'));
    }

    public function create(Request $request, AdminRepository $rep)
    {
        $page        = $request->input('page');
        $folder      = 'user';
        $title       = '添加用户';
        $targetUrl   = route('admin.user.index', ['page' => $page]);
        $targetTitle = '用户列表';
        $formUrl     = route('admin.user.store', ['page' => $page]);
        $user        = $rep->model('User');
        $role        = $rep->model('Role')->all();

        return view(
            'admin::partials.create',
            compact('user', 'role', 'folder', 'title', 'formUrl', 'targetUrl', 'targetTitle')
        );
    }

    public function edit($id, Request $request, AdminRepository $rep)
    {
        $page        = $request->input('page');
        $folder      = 'user';
        $title       = '修改用户';
        $targetUrl   = route('admin.user.index', ['page' => $page]);
        $targetTitle = '用户列表';
        $formUrl     = route('admin.user.store', ['page' => $page]);
        $user        = $rep->model('User')->find($id);
        $role        = $rep->model('Role')->all();

        return view(
            'admin::partials.edit',
            compact('user', 'role', 'folder', 'title', 'targetUrl', 'targetTitle', 'formUrl', 'id')
        );
    }

    public function store(StoreUserRequest $request, AdminRepository $rep)
    {
        $page         = $request->input('page');
        $id           = $request->input('id');
        $roles        = $request->input('rids');
        $hasRoleCheck = $request->input('has_rids');
        $user         = $rep->model('User')->find($id);
        if ($id) {
            $pass = $request->input('password');
            $user->fill($request->except(['password', 'page', 'id', 'rids']));
            if ($pass) $user->password = bcrypt($pass); // change password
            $user->save();
            $redirectUrl = route('admin.user.index', ['page' => $page]);
        } else {
            $user = $rep->apply('User')->store($request, null, ['password' => bcrypt($request->input('password'))]);
            $redirectUrl = route('admin.user.index');
        }
        if ($hasRoleCheck) {
            $user->roles()->detach();
            $user->assignRole($roles);
        }

        return redirect($redirectUrl)->withSuccess($id ? '修改成功！' : '添加成功！');
    }

    public function delete($id, AdminRepository $rep)
    {
        $user = $rep->model('User')->find($id);
        if (can_delete($user)) {
            $user->roles()->detach();
            $user->delete();
            return redirect()->back()->withSuccess("删除用户(#" . $id . " - " . $user->username . ")成功");
        } else {
            return redirect()->back()->withErrors("删除用户(#" . $id . " - " . $user->username . ")失败，当前用户不允许被删除");
        }
    }

    public function search(Request $request, AdminRepository $rep)
    {
        $keywords = $request->input('keywords');
        if ($keywords) {
            $list = $rep->builder('User')->search($keywords, ['username', 'phone', 'email'], 15);
        } else {
            $list = $rep->model('User')->pagination(15);
        }

        return view('admin::user.index', compact('list', 'keywords'));
    }
}
