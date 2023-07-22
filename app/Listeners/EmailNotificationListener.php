<?php

namespace App\Listeners;

use App\Events\NewClaimAudited;
use App\Events\NewClaimRegistered;
use App\Jobs\ProcessClaimAuditedEmail;
use App\Mail\AuditMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailNotificationListener
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
    public function handle(NewClaimAudited $event): void
    {
        dispatch(new ProcessClaimAuditedEmail($event->claimid))->onConnection('redis');
    }
}
