<?php

namespace App\Observers;

use App\Models\Log;
use Nuwave\Lighthouse\Execution\Utils\Subscription;

class LogObserver
{
    /**
     * Handle the log "created" event.
     *
     * @param \App\Models\Log $log
     *
     * @return void
     */
    public function created(Log $log)
    {
        Subscription::broadcast('logCreated', $log);
    }
}
