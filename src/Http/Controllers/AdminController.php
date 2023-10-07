<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public $moduleName    = 'admin';
    public $folder        = 'user';

    public function default_index(Request $request, $list, $modelName = '', $route = null, $ext = [])
    {
        $page        = $request->input('page');
        $folder      = $this->folder;
        $title       = $modelName . '列表';
        $targetUrl   = $route ?? route('admin.' . $this->folder . '.create');
        $targetTitle = '添加' . $modelName;

        $data        = compact('folder',  'title', 'targetUrl', 'targetTitle', 'list');
        $datas       = $ext ? array_merge($data, $ext) : $data;

        return view($this->moduleName . '::' . $this->folder . '.index', $datas);
    }

    public function default_create(Request $request, $model, $modelName = '', $targetUrl = null, $formUrl = null, $ext = [])
    {
        $page        = $request->input('page');
        $folder      = $this->folder;
        $title       = '添加' . $modelName;
        $targetTitle = $modelName . '列表';
        $targetUrl   = $targetUrl ?? route('admin.' . $this->folder . '.index', ['page' => $page]);
        $formUrl     = $formUrl ?? route('admin.' . $this->folder . '.store', ['page' => $page]);

        $data        = compact('model', 'folder', 'title', 'formUrl', 'targetUrl', 'targetTitle');
        $datas       = $ext ? array_merge($data, $ext) : $data;

        return view('admin::partials.create', $datas);
    }

    public function default_edit($id, Request $request, $model, $modelName = '', $targetUrl = null, $formUrl = null, $ext = [])
    {
        $page        = $request->input('page');
        $folder      = $this->folder;
        $title       = $modelName . '管理';
        $subtitle    = '修改' . $modelName;
        $targetTitle = $modelName . '列表';
        $targetUrl   = $targetUrl ?? route('admin.' . $this->folder . '.index', ['page' => $page]);
        $formUrl     = $formUrl ?? route('admin.' . $this->folder . '.store', ['page' => $page]);

        $data        = compact('model', 'folder', 'title', 'subtitle', 'targetUrl', 'targetTitle', 'formUrl', 'id');
        $datas       = $ext ? array_merge($data, $ext) : $data;

        return view('admin::partials.edit', $datas);
    }

    public function default_store(Request $request, $model, $targetUrl = null)
    {
        $page = $request->input('page');
        $id   = $request->input('id');
        $model->fill($request->all());
        $model->save();
        $targetUrl   = $targetUrl ?? route('admin.' . $this->folder . '.index', ['page' => $page]);

        return redirect($targetUrl)->withSuccess($id ? '修改[' . $id . ']成功！' : '添加成功！');
    }

    public function default_delete($id, $model, $title = '')
    {
        if ($model) {
            if (can_delete($model)) {
                $model->delete();
                $this->afterDeleted($model);
                return redirect()->back()->withSuccess('删除' . $title . '#(' . $id . ')成功');
            } else {
                return redirect()->back()->withErrors('删除' . $title . '(#' . $id . ')失败，当前选项不允许被删除');
            }
        }
        return redirect()->back()->withErrors('删除失败，无当前数据#' . $id);
    }

    protected function afterDeleted($model)
    {
    }
}
