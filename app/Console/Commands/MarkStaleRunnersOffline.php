<?php

namespace App\Console\Commands;

use App\Models\Runner;
use Illuminate\Console\Command;

class MarkStaleRunnersOffline extends Command
{
    protected $signature = 'monitor:stale-runners';
    protected $description = 'Mark runners that have not sent a heartbeat in 10 minutes as offline';

    public function handle(): void
    {
        Runner::markStaleAsOffline();
        $this->info('Stale runners marked offline.');
    }
}
