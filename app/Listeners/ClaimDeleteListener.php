<?php

namespace App\Listeners;

use App\Events\ClaimDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClaimDeleteListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClaimDeleted $event): void
    {
        //
    }
}
