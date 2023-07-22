<?php

namespace App\Http\Controllers;

use App\Events\ClaimFileUploaded;
use App\Events\NewClaimAudited;
use App\Listeners\EmailNotificationListener;
use App\Models\Claim;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AuditController extends Controller
{
   
    public function pendingAudit(){
        $claims = Claim::where('claim_state_id', 2)->get();
        return view('audit.pending', compact('claims'));
    }

    public function auditedClaims(){
        $claims = Claim::where('claim_state_id', 4)->get();
        return view('audit.audited', compact('claims'));
    }

    public function auditClaim(Request $request){
        $claimid = $request->query("claimid", null);
        if($claimid == null){
            return back()->with('error', 'Oops, Claim not found');
        }

        $claim = Claim::where('claimid', $claimid)->first();
        return view('audit.audit', compact('claim'));
    }

    /**
     * UPLOAD AUDITED CLAIMS
     */
    public function uploadAuditedFiles(Request $request){
        try{
            if($request->hasFile('claimfiles')){
           
                $claim = Claim::where('claimid', $request->claimid)->first();
                if($claim){
                    $uploadedFiles = $request->file('claimfiles');
                    foreach($uploadedFiles as $file){
                        $filename = time().$file->getClientOriginalName();

                        $uploadPath = $claim->claim_directory.'/AUDITED';
                        // $storageDestinationPath= storage_path($uploadPath);

                        // if (!File::exists( $storageDestinationPath)) {
                        //     File::makeDirectory($storageDestinationPath, 0755, true);
                        // }
                        Storage::putFileAs(
                            $uploadPath,
                            $file,
                            $filename
                        );
                    }      
                    if($request->hasFile('claimfiles'))  {
                        event(new ClaimFileUploaded($uploadedFiles, Auth::user()->id, Auth::user()->department?->id, $claim->id, 1));
                    }
                    
                    event(new NewClaimAudited($claim->id));
                    
                    return [
                        'status' => 'success',
                        'message' => 'Audited files successfully uploaded'
                    ];
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Claim with Claim ID '.$request->claimid.' not found',
                    ]);
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Audited files successfully uploaded'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please upload the audited files'
                ]);
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Oops, unable to upload audited files'
            ]);
        }
    }
}
