<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Artcoder\Ladmin\Repositories\AdminRepository;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(AdminRepository $admin)
    {
        dump('config seeder start...');
        // $config->create([
        //     'item'        => 'is_register',
        //     'type'        => 'checkbox',
        //     'description' => '是否开启网站注册',
        //     'content'     => 'on',
        // ]);
        $admin->clearCache();
        dump('config seeder done.');
    }
}
