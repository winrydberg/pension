<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Claim;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Scheme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SchemeController extends Controller
{
    public function pendingReceipt(Request $request){
        $user = Auth::user();
        $permissions = $user->permissions;
        $schemes = [];

        //get all schemes assigned to user
        foreach($permissions as $p){
            $schemename = explode('--', $p->name);
            $scheme = Scheme::where('name', $schemename[0])->where('tiertype', $schemename[1])->first();
            array_push($schemes, $scheme?->id);
        }

        $schemeid = $request->query('schemeid', null);
        $claims =  [] ;
        $selectedscheme = null;

        if($schemeid==null){
            $claims = Claim::where('claim_state_id', 4)->whereIn('scheme_id', $schemes)->get();
        }else{
            $selectedscheme = Scheme::find($schemeid);
            $claims = Claim::where('claim_state_id', 4)->where('scheme_id', $schemeid)->get();
        }
       

        return view('scheme.pending', compact('permissions', 'claims', 'selectedscheme'));
    }

    public function receiveClaim(Request $request){
        try{
            $claimid = $request->claimid;
            $invchecque = mt_rand(1000, 99999);
            $payment = Payment::create([
                'chequeno' => $invchecque,
                'invoice' => $invchecque,
                'user_id' => Auth::user()->id,
                'claim_id' => $claimid
            ]);
            Claim::where('id', $claimid)->update([
                'department_reached' => 'Accounting | Scheme Administrators',
                'claim_state_id' => 6,
                // 'payment_id' => $payment->id
            ]);

            $claim = Claim::find($claimid);
           
            $company = Company::select('id', 'name')->where('id',$claim->company_id)->first();
            activity()
                    ->causedBy(Auth::user())
                    ->performedOn($claim)
                    ->withProperties(['company' => $company])
                    ->log(config('enums.CLAIM_RECEIVED'), config('enums.CLAIM_RECEIVED'));
            return response()->json([
                'status' => 'success',
                'message' => 'Claim has been received!!!'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to process action. Please try again'
            ]);
        }
    }


    public function receivedClaims(){
        $user = Auth::user();
        $permissions = $user->permissions;
        $schemes = [];
        //get all schemes assigned to user
        foreach($permissions as $p){
            $schemename = explode('--', $p->name);
            $scheme = Scheme::where('name', $schemename[0])->where('tiertype', $schemename[1])->first();
            array_push($schemes, $scheme?->id);
        }

        $claims = Claim::where('claim_state_id', 6)->whereIn('scheme_id', $schemes)->get();
        return view('scheme.received', compact('claims'));
    }


    public function assignedSchemes(){
        $user = Auth::user();
        $permissions = $user->permissions;
        $schemes = [];
        //get all schemes assigned to user
        foreach($permissions as $p){
            $schemename = explode('--', $p->name);
            $scheme = Scheme::where('name', $schemename[0])->where('tiertype', $schemename[1])->first();
            array_push($schemes, $scheme);
        }

        return view('scheme.assignedschemes', compact('schemes'));
    }


    public function pendingPayments(){
        $user = Auth::user();
        $permissions = $user->permissions;
        $schemes = [];
        //get all schemes assigned to user
        foreach($permissions as $p){
            $schemename = explode('--', $p->name);
            $scheme = Scheme::where('name', $schemename[0])->where('tiertype', $schemename[1])->first();
            array_push($schemes, $scheme->id);
        }

        $claims = Claim::whereIn('scheme_id', $schemes)->where('claim_state_id', 6)->pluck('id');

        $employees = Customer::whereIn('claim_id', $claims)->where('ispaid', false)->orWhere('ispaid', null)->where('is_sent_to_bank', false)->with('claims')->get();

        // dd($employees);
        $banks = Bank::all();

        return view('scheme.pendingpayments', compact('employees', 'banks'));
    }


    //NOT IN USE AGAIN
    public function sendPaymentToBank(Request $request){
        try{
            $customerid = $request->id;
            $bankid = $request->bank;

            if($customerid == null || $bankid == null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee info not found'
                ]); 
            }

            $employee = Customer::find($customerid);

            if($employee){
                $employee->update([
                    'bank_id' => $bankid,
                    'is_sent_to_bank' => true
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Payment Successfully sent to bank'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send payment to bank. Please try again'
            ]);
        }
    }

    public function paymentSentToBank(Request $request){
        try{  //PAYMENT_SENT_TO_BANK
            $ids = explode(",",$request->ids);
            $claimids = explode(",",$request->claimid);

            if($request->hasFile('schemefiles')){
                $files = $request->file('schemefiles');
                foreach($ids as $id) {
                    $claim = Claim::find(trim($id));
                    $thefiles = [];
                    foreach($files as $key => $file){
                        $filename = time().$file->getClientOriginalName();
                        $claimPath = $claim?->claim_directory.'/SCHEME_SENT_TO_BANK/';
                        $path = Storage::putFileAs(
                            $claimPath,
                            $file,
                            $filename
                        );
                        array_push($thefiles, $path);
                    }

                    $claim?->update([
                        'claim_state_id' => 10,
                        'sent_to_bankfiles' => json_encode($thefiles)
                    ]);

                    $company = Company::select('id', 'name')->where('id',$claim?->company_id)->first();
                    activity()
                            ->causedBy(Auth::user())
                            ->performedOn($claim)
                            ->withProperties(['company' => $company])
                            ->log(config('enums.PAYMENT_SENT_TO_BANK'), config('enums.PAYMENT_SENT_TO_BANK'));
                }
            }else{
                foreach($ids as $id) {
                    $claim = Claim::find($id);
                    $claim?->update([
                        'claim_state_id' => 10,
                    ]);
                    $company = Company::select('id', 'name')->where('id',$claim?->company_id)->first();
                    activity()
                            ->causedBy(Auth::user())
                            ->performedOn($claim)
                            ->withProperties(['company' => $company])
                            ->log(config('enums.PAYMENT_SENT_TO_BANK'), config('enums.PAYMENT_SENT_TO_BANK'));
                }
                
            }

           

            return response()->json([
                'status' => 'success',
                'message' => 'Payment Successfully sent to bank'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send payment to bank. Please try again'
            ]);
        }
    }
}
