<?php

namespace App\Listeners;

use App\Events\NewClaimAudited;
use App\Models\Claim;
use App\Models\Company;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class ClaimAuditListener
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
        $claim = Claim::find($event->claimid);
        if($claim){
            $company = Company::select('id', 'name')->where('id',$claim->company_id)->first();
            activity()
            ->causedBy(Auth::user())
            ->performedOn($claim)
            ->withProperties(['company' => $company])
            ->log(config('enums.CLAIM_AUDITED'), config('enums.CLAIM_AUDITED'));

            $user = Auth::user();
            $claim->update([
                'department_reached' => 'Accounting | Scheme Admins',
                'audited' => true,
                'auditor_id' => $user->id,
                'audited_by' => $user->firstname.' '.$user->lastname,
                'claim_state_id' => 4,
            ]);
        }
    }
}
