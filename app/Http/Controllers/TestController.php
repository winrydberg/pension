<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class TestController extends Controller
{
    public function getActivities(Request $request){
        // $claimid = $request->query('id', null);
        $lastLoggedActivity = Activity::all()->last();
        $claim = $lastLoggedActivity->subject;

        dd($claim);
    }
}
