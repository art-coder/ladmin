<?php

namespace Artcoder\Ladmin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use Artcoder\Ladmin\Console\Setup;
use Artcoder\Ladmin\Console\Permission;
use Artcoder\Ladmin\Console\Seeder;
use Artcoder\Ladmin\Console\Refresh;

// module:migrate
// module:migrate-refresh
// module:migrate-reset
// module:migrate-rollback

use Artcoder\Ladmin\Http\Middleware\Admin as AdminMiddleware;
use Artcoder\Ladmin\Providers\RouteServiceProvider;

use Spatie\Permission\PermissionServiceProvider;

// use Nwidart\Modules\Laravel\LaravelFileRepository;

// https://www.jianshu.com/p/18d3b77a13f3?utm_campaign=maleskine&utm_content=note&utm_medium=seo_notes&utm_source=recommendation

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->offerPublishing();
        $this->offerLoading();
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        $this->sqlDebug();
        $this->addMiddlewareAlias('admin', AdminMiddleware::class);

        // app('modules')->addLocation(__DIR__);
    }

    public function register()
    {
        // $this->app->singleton('admin', function () {
        //     return new Admin;
        // });
        // $this->app->singleton('admin', function ($app) {
        //     return new Admin($app, 'Admin', __DIR__);
        // });
        $this->app->singleton('admin', function ($app) {
            $path = __DIR__;
            return new \Nwidart\Modules\Laravel\Module($app, 'Admin', $path);
        });
        // $this->app->singleton('admin', function ($app) {
        //     return new LaravelFileRepository($app, 'Admin', __DIR__);
        // });

        // Nwidart\Modules\FileRepository@scan

        $this->mergeConfigFrom(
            __DIR__ . '/Config/admin.php',
            'admin'
        );
        $this->mergeConfigFrom(__DIR__ . '/Config/config.php', 'admin');

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);
        $this->commands([
            Setup::class,
            Permission::class,
            Seeder::class,
            Refresh::class,
        ]);
    }

    protected function offerPublishing()
    {
        // config
        $this->publishes([
            __DIR__ . '/Config/admin.php' => config_path('admin.php'),
        ]);
        $this->publishes([
            __DIR__ . '/Config/status.php' => config_path('status.php'),
        ]);
        // public style ....
        $this->publishes([
            __DIR__ . '/../assets' => public_path('assets'),
        ]);
    }

    protected function offerLoading()
    {
        // migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        // views
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'admin');
        // component
        Blade::component('admin-menu', \Artcoder\Ladmin\Components\Menu::class);
    }

    // 添加中间件的别名方法
    protected function addMiddlewareAlias($name, $class)
    {
        $router = $this->app['router'];

        if (method_exists($router, 'aliasMiddleware')) {
            return $router->aliasMiddleware($name, $class);
        }

        return $router->middleware($name, $class);
    }

    protected function sqlDebug()
    {
        if ($this->app->environment() !== 'production') {
            // 记录sql日志
            \DB::listen(
                function ($sql) {
                    foreach ($sql->bindings as $i => $binding) {
                        if ($binding instanceof \DateTime) {
                            $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                        } else {
                            if (is_string($binding)) {
                                $sql->bindings[$i] = "'$binding'";
                            }
                        }
                    }
                    // Insert bindings into query
                    $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
                    $query = vsprintf($query, $sql->bindings);
                    // Save the query to file
                    $logFile = fopen(
                        storage_path('logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '_query.log'),
                        'a+'
                    );
                    fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $query . PHP_EOL);
                    fclose($logFile);
                }
            );
        }
    }

}
