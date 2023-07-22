<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ClaimState;
use App\Models\Issue;
use App\Models\Scheme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request){

        $user = Auth::user();
        $permissions = $user->permissions;
        $schemeIds = [];
        //get all schemes assigned to user
        foreach($permissions as $p){
            $schemename = explode('--', $p->name);
            $scheme = Scheme::where('name', $schemename[0])->where('tiertype', $schemename[1])->first();
            array_push($schemeIds, $scheme->id);
        }
        // $pendingProcessing = Claim::where('claim_state_id', 1)->count();
        $pendingAudit = Claim::where('claim_state_id', 2)->count();
        $pendingSchemeReceipt = Claim::where('claim_state_id', 4)->whereIn('scheme_id', $schemeIds)->count();
        $pendingIssues = Issue::where('resolved', false)->get();
        $claimsWithIssueCount =   Claim::where('has_issue', true)->count();
        $unProcessedCount = Claim::where('claim_state_id', 1)->count();
        $schemes = Scheme::all();

         // $activities = $this->activityRepository->getActivityByDate(date('Y-m-d'));
        
 
         if($request->query('date', null) != null){
            $currentMonthYear = date($request->query('date'));
            $month = date('m', strtotime($currentMonthYear));
            $year = date('Y', strtotime($currentMonthYear));
            $claimsByDate = Claim::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'desc')->with('company')->get()->groupBy(function($data) {
                return $data->created_at->format('Y-m-d');
            });
         }else{
            $currentMonthYear = date('Y-m');
            $month = date('m');
            $year = date('Y');
            $claimsByDate = Claim::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'desc')->with('company')->get()->groupBy(function($data) {
                return $data->created_at->format('Y-m-d');
            });
         }


        // $states = ClaimState::with('claims')->where(function($));
        // $states = ClaimState::with('claim')->where('claim.created_at', function($q) {
        //     $q->whereIn('created_at',[Carbon::now()->subDays(7), Carbon::now()]);
        // })->get();

        $states = ClaimState::withCount(['claim' => function($query) {
             $query->whereBetween('created_at',[Carbon::now()->subDays(1), Carbon::now()]);
        }])->get();

    

        // if($request->query('date', null) != null){
        //     $currentMonthYear = date($request->query('date'));
        //     $claimsByDate = $this->claimRepository->getClaimByMonth($request->query('date'));
        // }else{
        //     $currentMonthYear = date('Y-m');
        //     $claimsByDate = $this->claimRepository->getClaimByMonth(null);
        // }

        
        return view('index', compact('pendingSchemeReceipt','pendingAudit', 'claimsWithIssueCount', 'pendingIssues', 'unProcessedCount', 'schemes','claimsByDate', 'currentMonthYear', 'states'));
    }
}
