<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Scheme;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $searchby = $request->query('searchby', null);
        $term = $request->query('term', null);
        if($searchby == null){
            return view('claims.search');
        }

        switch($searchby){
            case 1:
                $claims = Claim::where('claimid', $term)->get();
                return view('claims.search', compact('claims'));

            case 2:
                $customers = Customer::where('name', 'like', '%'.$term.'%')->with('claims')->orderBy('id', 'desc')->get();
                // dd($customers);
                return view('claims.search', compact('customers'));
            case 3:
                $companies = Company::where('name', 'like', '%'.$term.'%')->pluck('id');
                $claims = Claim::whereIn('company_id', $companies)->get();
                return view('claims.search', compact('claims'));
            case 4:
                $schemes = Scheme::where('name', 'like', '%'.$term.'%')->pluck('id');
                $claims = Claim::whereIn('scheme_id', $schemes)->get();
                return view('claims.search', compact('claims'));
            case 5:
                return view('claims.search', compact(''));
            default:
                return view('claims.search');
        }
        
    }
}
