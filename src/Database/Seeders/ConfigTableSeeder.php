<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Artcoder\Ladmin\Repositories\ConfigRepository;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ConfigRepository $config)
    {
        dump('config seeder start...');
        // $config->create([
        //     'item'        => 'is_register',
        //     'type'        => 'checkbox',
        //     'description' => '是否开启网站注册',
        //     'content'     => 'on',
        // ]);
        $config->clearCache();
        dump('config seeder done.');
    }
}
