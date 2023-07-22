<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function claimEmployees(Request $request){
        $claimid = $request->query('claimid', null);
         if($claimid == null){
            return back()->with('error', 'No Claim Selected');
         }
        //  $customers = Customer::all();
         $customers = Customer::where('claim_id', $claimid)->get();
         $claim = Claim::where('id', $claimid)->first();

         if($claim == null){
            return back()->with('error', 'Claim not found');
         }

        // dd($customers);

         return view('claims.employees', compact('claim', 'customers'));
    }
}
