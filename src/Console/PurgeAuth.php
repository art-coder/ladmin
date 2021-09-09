<?php

namespace Artcoder\Ladmin\Console;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * 每天凌晨固定某点运行，清理过期的token
 * 由于现在token没有过期机制，所以这里用程序定期清理
 */

class PurgeAuth extends Command
{

    protected $signature = 'auth:purge';

    protected $description = 'purge api auth token.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(PersonalAccessToken $model)
    {
        dump('purge api overdue auth token start...');
        $tokens = $model->all();
        $now = time();
        foreach ($tokens as $token) {
            $up   = strtotime($token->updated_at);
            $diff = $now - $up;
            if ($diff > 3 * 31 * 24 * 3600) {// token 3个月过期，自动删除
                $token->delete();
            }
        }
        dump('purge api overdue auth token end...');
    }

}
