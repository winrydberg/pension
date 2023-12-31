<?php

namespace App\Listeners;

use App\Events\ClaimDownloaded;
use App\Models\Claim;
use App\Models\Company;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class ClaimDownloadListener
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
    public function handle(ClaimDownloaded $event): void
    {
        if($event->claim instanceof Claim){ 
            $company = Company::select('id', 'name')->where('id',$event->claim->company_id)->first();
            activity()
            ->causedBy(Auth::user())
            ->performedOn($event->claim)
            ->withProperties(['company' => $company])
            ->log(config('enums.CLAIM_FILES_DOWNLOADED'), config('enums.CLAIM_FILES_DOWNLOADED'));
        }
    }
}
