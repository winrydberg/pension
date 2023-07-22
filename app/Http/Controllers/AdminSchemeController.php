<?php

namespace App\Http\Controllers;

use App\Models\ClaimState;
use App\Models\Scheme;
use Exception;
use Illuminate\Http\Request;

class AdminSchemeController extends Controller
{
    public function  newScheme(){
        return view('extras.newscheme');
    }

    public function saveScheme(Request $request){
        try{
            Scheme::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Scheme has been successfully added'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Oops, something went wrong. Unable to add scheme'
            ]);
        }
    }

    public function claimState(){
        $states = ClaimState::withCount('claim')->get();
        return view('extras.claimstates', compact('states'));
    }
}
