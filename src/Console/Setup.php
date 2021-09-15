<?php

namespace Artcoder\Ladmin\Console;

use Illuminate\Console\Command;

class Setup extends Command
{

    protected $signature = 'ladmin:setup';
    protected $description = 'init ladmin.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('ladmin init...');
        // $this->call('config:clear');

        $this->prePermission();
        $this->preModule();
        $this->preLadmin();

        $this->migrate();
        $this->seed();

        $this->info('ladmin done.');
    }

    protected function prePermission()
    {
        // ====> laravel permission
        $this->info('laravel-permission publish start...');
        $this->call('vendor:publish', [ // call
            '--provider' => 'Spatie\Permission\PermissionServiceProvider'
        ]);
        $this->info('laravel-permission publish end.');
    }

    protected function preModule()
    {
        // ====>  laravel module
        $this->info('laravel-module publish start...');
        $this->call('vendor:publish', [ // callSilent
            '--provider' => 'Nwidart\Modules\LaravelModulesServiceProvider'
        ]);
        $this->info('laravel-module publish end.');
    }

    protected function preLadmin()
    {
        // ====>  ladmin
        $this->info('ladmin publish start...');
        $this->call('vendor:publish', [
            '--provider' => 'Artcoder\Ladmin\AdminServiceProvider'
        ]);
        $this->info('ladmin publish done.');
    }

    protected function migrate()
    {
        // ====>  all table migrate
        $this->info('ladmin migrate start...');
        $this->call('migrate');
        $this->info('ladmin migrate done.');
    }

    protected function seed()
    {
        // ====>  添加测试数据
        // $this->call('db:seed');
        $this->call('ladmin:seed');
    }
}
