<?php

namespace Artcoder\Ladmin\Console;

use Illuminate\Console\Command;

use Artcoder\Ladmin\Database\Seeders\LadminDatabaseSeeder;

class Seeder extends Command
{

    protected $signature = 'ladmin:seed';
    protected $description = 'ladmin test data seeder.';
    protected $permission = null;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('db:seed', [ '--class' => LadminDatabaseSeeder::class ]);
    }

}
