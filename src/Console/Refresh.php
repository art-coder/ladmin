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
        $this->call('migrate:refresh');
        // $this->call('module:migrate-refresh');
        // 添加测试数据
        $this->call('ladmin:seed');
        $this->call('db:seed');
        // $this->call('module:seed');
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
