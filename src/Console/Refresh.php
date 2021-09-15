<?php

namespace Artcoder\Ladmin\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Refresh extends Command
{

    protected $signature = 'ladmin:refresh';
    protected $description = 'refresh the system and seed some data to database.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // 清空所有的数据
        $this->call('migrate:refresh');
        // $this->call('module:migrate-refresh');// 只能清空module的数据，不能清空admin的数据

        // 添加测试数据
        $this->call('ladmin:seed');
        // $this->call('db:seed');// 所有的测试数据入库

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
