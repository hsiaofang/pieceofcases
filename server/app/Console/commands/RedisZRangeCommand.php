<?php 
// app/Console/Commands/RedisZRangeCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisZRangeCommand extends Command
{
    protected $signature = 'redis:zrange {key} {start} {end}';
    protected $description = 'Get the range of members from a sorted set';

    public function handle()
    {
        $key = $this->argument('key');
        $start = $this->argument('start');
        $end = $this->argument('end');

        $members = Redis::zrange($key, $start, $end);
        $this->info(json_encode($members));
    }
}
