<?php

namespace App\Listeners;

use App\Events\NewIssueRaised;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewIssueListener
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
    public function handle(NewIssueRaised $event): void
    {
        //
    }
}
