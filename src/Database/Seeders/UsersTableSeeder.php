<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Artcoder\Ladmin\Repositories\BaseRepository;

class UsersTableSeeder extends Seeder
{

    protected $model = null;

    public function __construct(BaseRepository $model)
    {
        $this->model = $model->model('user');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        dump('user seeder start...');
        $isDev = app()->environment() !== 'production';
        if ($isDev) {
            $adminPass = bcrypt('123456');
        } else {
            $adminPass = bcrypt('artcoderadmin159753');
        }
        // super admin
        $this->model->create([
            'username'       => 'ArtCoder',
            'avatar'         => 'https://dss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=1430948590,2484535776&fm=26&gp=0.jpg',
            'phone'          => '13800138000',
            'email'          => 'admin@artcoder.com',
            'is_super_admin' => 1,
            'status'         => 0,
            'password'       => $adminPass,
        ]);

        if ($isDev) {
            // editor user
            $this->model->create([
                'username' => 'edit',
                'avatar'   => 'https://dss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=2019419245,1715884093&fm=26&gp=0.jpg',
                'phone'    => '13800138001',
                'email'    => 'edit@artcoder.com',
                'password' => $adminPass,
                'status'   => 0,
            ]);

            // other user
            // User::factory()
            $this->model->factory()
                ->times(8)
                ->create();
        }

        dump('user seeder done.');
    }
}
