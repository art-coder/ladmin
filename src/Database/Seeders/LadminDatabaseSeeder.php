<?php

namespace Artcoder\Ladmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LadminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(PermissionInitTableSeeder::class); // admin permission
        // $this->call(ModulePermissionTableSeeder::class); // module permission
        $this->call(ConfigTableSeeder::class);
    }
}
