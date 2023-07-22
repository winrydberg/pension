<?php

namespace App\Jobs;

use App\Mail\AuditMail;
use App\Models\Claim;
use App\Models\Scheme;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessClaimAuditedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $claimid;
    /**
     * Create a new job instance.
     */
    public function __construct($claimid)
    {
        $this->claimid = $claimid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $claim = Claim::find($this->claimid);
        if($claim != null){
            $scheme = Scheme::find($claim->scheme_id);

            $users = User::permission($scheme->name.'--'.$scheme->tiertype)->get();

            Log::info($users);

            foreach($users as $user){
                Mail::to('edwinsenunyeme5@gmail.com')->send(new AuditMail($claim));
            }

        }
        //
    }
}
