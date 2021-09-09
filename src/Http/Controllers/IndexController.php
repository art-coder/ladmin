<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Http\Request;
use Artcoder\Ladmin\Http\Requests\ResetPasswordRequest;
use Artcoder\Ladmin\Repositories\ConfigRepository;
use Artcoder\Ladmin\Repositories\UserRepository;
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

    public function setting(ConfigRepository $config)
    {
        $settings = $config->info();
        return view('admin::setting.index', compact('settings'));
    }

    public function create(ConfigRepository $config)
    {
        $setting     = $config->makeModel();
        $folder      = 'setting';
        $title       = '添加配置';
        $targetUrl   = route('admin.setting.index');
        $targetTitle = '配置管理';
        $formUrl     = route('admin.setting.create');

        return view('admin::partials.create', compact('setting', 'folder', 'title', 'formUrl', 'targetUrl', 'targetTitle'));
    }

    public function save(Request $request, ConfigRepository $config)
    {
        $all     = $request->all();
        $item    = $all['item'];
        $content = $all['content'];
        foreach ($item as $key => $value) {
            $one          = $config->firstOrNew(['item' => $value]);
            $one->content = $content[$key];
            $one->save();
        }
        $config->clearCache();
        return redirect('/admin/setting/index')->withSuccess('修改配置成功！！');
    }

    public function saveSingle(Request $request, ConfigRepository $config)
    {
        $item        = $request->get('item');
        $type        = $request->get('type');
        $description = $request->get('description');
        $content     = $request->get('content');
        if ($item && $description && $content) {
            $one              = $config->firstOrNew(['item' => $item]);
            $one->type        = $type;
            $one->description = $description;
            $one->content     = $content;
            $one->save();
            $config->clearCache();
            return redirect('/admin/setting/index')->withSuccess('添加配置成功！！');
        } else {
            return redirect()->back()->withErrors('请填写正确的配置项！！');
        }
    }

    public function password()
    {
        return view('admin::setting.password');
    }

    public function savePassword(ResetPasswordRequest $request, UserRepository $user)
    {
        $update = array(
            'password' => bcrypt($request->password),
        );
        $result = $user->update($update, auth()->user()->id);
        return redirect(route('admin.setting.password'))->withSuccess('修改密码成功，请下次使用新密码登录！！');
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
