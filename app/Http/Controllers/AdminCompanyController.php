<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminCompanyController extends Controller
{
    public function newCompany(){
        return view('extras.newcompany');
    }

    public function saveCompany(Request $request){
        try{
            $validated = $request->all();
            $validated['region_id'] = 8;
            Company::create($validated);
            return response()->json([
                'status' => 'success',
                'message' => 'Company successfully added'
            ]);
        }catch(Exception $e){
            Log::info("====================NEW COMPANY REGISTSTRATION=======================");
            Log::info($e->getMessage());
            Log::info("====================NEW COMPANY REGISTSTRATION=======================");
            return redirect()->back()->with('error', 'Oops Something went wrong. Please try again');
        }
    }
}
