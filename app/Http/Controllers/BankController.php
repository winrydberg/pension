<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BankController extends Controller
{
    public function paymentReports(Request $request){
        try{
            
        }catch(Exception $e){
            return response()->json([
                'OK'
            ]);
        }
    }



    public function banks(){
        // $banks = Bank::all();
        $banks = Bank::withCount(['employees' => function($query) {
            $query->where('ispaid', false)->orWhere('ispaid', null)->where('is_sent_to_bank', true);
       }])->get();

    //    dd($banks);
        return view('extras.banks', compact('banks'));
    }

    public function addBank(Request $request){
        try{
            if(!$request->filled('name')){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please enter bank name to add bank'
                ]);
            }
            Bank::create([
                'name' => $request->name
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Bank Successfully added'
            ]);
        }catch(Exception $e) {
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to add bank. Please try again'
            ]);
        }
    }
}
