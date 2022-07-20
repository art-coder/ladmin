<?php

namespace Artcoder\Ladmin\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Artcoder\Ladmin\Repositories\BaseRepository;

class Permission extends Command
{

    protected $signature = 'permission:reload';
    protected $description = 'permission reload.';
    protected $permission = null;

    public function __construct(BaseRepository $base)
    {
        parent::__construct();
        $this->permission = $base->builder('Permission', 'Admin');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dump('permission seeder start...');
        $enabled     = app('modules')->getOrdered();
        $permissions = [];
        foreach ($enabled as $key => $module) {
            $name               = $module->getLowerName();
            $permissions[$name] = config($name . '.permissions');
        }
        foreach ($permissions as $config) {
            if ($config) {
                foreach ($config as $items) {
                    foreach ($items['list'] as $value) {
                        $name = $items['name'] . '-' . $value['can'];
                        $one  = $this->permission->findWhere(['name' => $name])->first();
                        if ($one) {
                            if ($one->info != $value['name']) {
                                $one->info = $value['name'];
                                $one->save();
                            }
                        } else {
                            $create = $this->permission->create([
                                'name'       => $name,
                                'info'       => $value['name'],
                                'guard_name' => 'web',
                            ]);
                        }
                    }
                }
            }
        }
        dump('permission seeder done.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
