<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Http\Requests\ResetPasswordRequest;
use Artcoder\Ladmin\Repositories\AdminRepository;
// use Artcoder\Ladmin\Services\Jdcloud;
use Storage;
use Artcoder\Ladmin\Libraries\Services\Uploads;

class IndexController extends Controller
{

    public $moduleName = 'admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        // dd(app('modules')->getOrdered());
        // dump('-------------');
        // dump(app('modules')->find('Cms'));
        // dd(app('admin'));
        $modules = get_modules_ordered();
        $hints   = [];
        $cookie  = $request->cookie('hints');
        // dump($cookie);
        $user    = $request->user();
        if ($cookie) {
            $cookie = json_decode($cookie, true);
        }
        // dump($cookie);
        foreach ($modules as $module) {
            $moduleName = $module->getLowerName();
            $path       = $module->getPath() . '/Config/hints.php';
            if (file_exists($path)) {
                $hintsArrs = require $path;
                if ($hintsArrs) {
                    foreach ($hintsArrs as $key => $value) {
                        if (!has_permission($user, $value['can'])) {
                            continue;
                        }
                        $hintsArr['moduleName'] = $moduleName;
                        $hintsArr['key']        = $key;
                        $hintsArr['name']       = $value['name'];
                        $hintsArr['active']     = !(isset($cookie[$moduleName]) && isset($cookie[$moduleName][$key]) && $cookie[$moduleName][$key] == false);
                        $hints[]                = $hintsArr;
                    }
                }
            }
        }
        // dump($hints);
        return view('admin::home.index', compact('hints'));
    }

    public function setting(AdminRepository $admin)
    {
        $settings = $admin->builder('Config', 'Admin')->info();
        return view('admin::setting.index', compact('settings'));
    }

    public function create(AdminRepository $admin)
    {
        $setting     = $admin->builder('Config', 'Admin');
        $folder      = 'setting';
        $title       = '????????????';
        $targetUrl   = route('admin.setting.index');
        $targetTitle = '????????????';
        $formUrl     = route('admin.setting.create');

        return view('admin::partials.create', compact('setting', 'folder', 'title', 'formUrl', 'targetUrl', 'targetTitle'));
    }

    public function save(Request $request, AdminRepository $admin)
    {
        $all     = $request->all();
        $item    = $all['item'];
        $content = $all['content'];
        foreach ($item as $key => $value) {
            $one          = $admin->model('Config', 'Admin')->firstOrNew(['item' => $value]);
            $one->content = $content[$key];
            $one->save();
        }
        $admin->model('Config', 'Admin')->clearCache();
        return redirect('/admin/setting/index')->withSuccess('????????????????????????');
    }

    public function saveSingle(Request $request, AdminRepository $admin)
    {
        $item        = $request->get('item');
        $type        = $request->get('type');
        $description = $request->get('description');
        $content     = $request->get('content');
        if ($item && $description && $content) {
            $one              = $admin->model('Config', 'Admin')->firstOrNew(['item' => $item]);
            $one->type        = $type;
            $one->description = $description;
            $one->content     = $content;
            $one->save();
            $admin->model('Config', 'Admin')->clearCache();
            return redirect('/admin/setting/index')->withSuccess('????????????????????????');
        } else {
            return redirect()->back()->withErrors('?????????????????????????????????');
        }
    }

    public function password()
    {
        return view('admin::setting.password');
    }

    public function savePassword(ResetPasswordRequest $request, AdminRepository $admin)
    {
        $update = array(
            'password' => bcrypt($request->password),
        );
        $result = $admin->builder('User', 'Admin')->update($update, auth()->user()->id);
        return redirect(route('admin.setting.password'))->withSuccess('?????????????????????????????????????????????????????????');
    }

    public function sensitive(Request $request)
    {
        if ($request->isMethod('post')) {
            $keywords = $request->input('keywords');
            Storage::disk('cache')->put('sensitive.txt', $keywords);
        } else {
            $exists = Storage::disk('cache')->exists('sensitive.txt');
            if ($exists) {
                $keywords = Storage::disk('cache')->get('sensitive.txt');
            } else {
                $keywords = '';
            }
        }
        return view('admin::setting.sensitive', ['keywords' => $keywords]);
    }

    public function upload(Request $request, Uploads $uploads)
    {
        $image        = $uploads->file($request->file('file'));
        // \Log::info($image);
        return response()->json([
            'error'   => 0,
            'url'     => $image,
        ]);
    }
}
