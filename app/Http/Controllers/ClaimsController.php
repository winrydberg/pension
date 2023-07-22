<?php

namespace App\Http\Controllers;

use App\Events\ClaimFileUploaded;
use App\Events\NewClaimRegistered;
use App\Events\NewPushNotificationEvent;
use App\Models\Claim;
use App\Models\ClaimFile;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Issue;
use App\Models\Scheme;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class ClaimsController extends Controller
{
    public function newClaim(){
        $companies = Company::all();
        $schemes = Scheme::all();
        return view('claims.newclaim', compact('companies','schemes'));
    }

    public function saveClaim(Request $request){
        try{
            $validated = $request->all();

            $user = Auth::user();
            $department = $user->department;
            $claim = Claim::create([
                'claimid' => 'CLM'.mt_rand(10000,99999),
                'user_id' => $user->id,
                'scheme_id' => $request->scheme_id,
                'department_id' => $user->department->id,
                'company_id' => $request->company_id,
                'description' => $request->description,
                'department_reached' => $department->name,
                'department_reached_id' => $department->id,
                'claim_state_id' => 1
            ]);

            $company = Company::select('id', 'name')->where('id',$request->company_id)->first();
            activity()
                ->causedBy($user)
                ->performedOn($claim)
                ->withProperties(['company' => $company])
                ->log(config('enums.NEW_CLAIM_REGISTERED'), config('enums.NEW_CLAIM_REGISTERED'));

            //send push notification to users
            // event(new NewClaimRegistered($claim,"New Claim", "A new claim has just been registered by".$user->firstname.". Claim ID: ".$claim->claimid, $claim->id));
            event(new NewPushNotificationEvent("New Claim", "A new claim has just been registered by".$user->firstname.". Claim ID: ".$claim->claimid, $claim->id));

          
            if($claim){
                return response()->json([
                    'status' => 'success',
                    'request_url' => url('/request-files?claimid='.$claim->claimid),
                    'processed_url' => url('/processed-files?claimid='.$claim->claimid),
                    'home_url' => url('/dashboard'),
                    'message' => 'Claim Successfully created. Please upload Processed Files or Request Documents'
                ]);
                // return redirect()->to('/claim-files?claimid='.$claim->claimid)->with('success', 'Claim Successfully created. Please Upload Claim Files');
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Oops something went wrong. Please try again'
                ]);
                // return redirect()->back()->with('error', 'Oops something went wrong. Please try again');
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to add claim. Please try again'
            ]);
        }
    }

    public function invalidClaims(){
        $claims = Claim::where('claim_state_id', 9)->get();
        return view('claims.invalidclaims', compact('claims'));
    }

    public function unProcessedClaims(){
        $claims = Claim::where('claim_state_id', 1)->get();
        return view('claims.unprocessedclaims', compact('claims'));
    }

    public function uploadProcessedFiles(Request $request){
        $claimid = $request->query('claimid', null);
        if(!$claimid){
            return back()->with('error', 'Claim not found');
        }
        return view('claims.processedfiles', compact('claimid'));
    }

    public function uploadRequestFiles(Request $request){
        $claimid = $request->query('claimid', null);
        if(!$claimid){
            return back()->with('error', 'Claim not found');
        }
        return view('claims.requestfiles', compact('claimid'));
    }

    public function saveProcessedFiles(Request $request){
        try{
            if($request->hasFile('claimfiles')){
                //create claim
                $claim = Claim::where('claimid', $request->claimid)->first();

                if(!$claim){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Claim not found. Please try again'
                    ]);
                }

                //upload file
                $files = $request->file('claimfiles');


                //extract store claim zip file
                // $result =  $this->claimRepository->storeClaimFiles($uploadedFiles,strtoupper(str_replace(' ','_',$claim->company->name)), $claim->id, $claim->scheme_id, 1);
                

                $excelfileError = false; 
                $files_contain_excel = false;        
                
                // $claim->processed = $claim->processed == 1 ? $claim->processed : (int)$claimstate;
                // $claim->save();

                $claimPath = '';
                $unAuditedPath = '';
                $schemeid = $claim->scheme_id;
                $companyName = $claim->company->name;

                if($claim->claim_directory == null || $claim->claim_directory==""){
                    $folder = (new DateTime())->format('Y_m_d');
                    $month = Carbon::now()->isoFormat('MMMM');
                    $year = Carbon::now()->isoFormat('Y');
                    $scheme = Scheme::find($schemeid);
                    $claimPath = "files/".$year.'/'.$month.'/'.$folder.'/'.$scheme->name.'/'.$companyName.'/'.$claim->claimid.'/';
                    $unAuditedPath = $claimPath."/UN_AUDITED/";
                }else{
                    $scheme = Scheme::find($schemeid);
                    $claimPath = $claim->claim_directory;
                    $unAuditedPath = $claimPath.'/UN_AUDITED/';
                }
                

                foreach($files as $file){
                    // $filename = time().$file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    if(in_array(strtolower($extension), ['xlsx', 'xls'])){
                        $files_contain_excel = true;
                            //validate the file for all fields
                            $data = Excel::toArray([],$file)[0][0];
                            if($data != null && is_array($data)){
                                $trimedData = [];
                                foreach($data as $d){
                                    array_push($trimedData, trim($d));
                                }
                                $validated = $this->validateData($trimedData);
                                if($validated){
                                    //store uploaded file
                                    $storeResult = $this->storeFile($file, $unAuditedPath);
                                    if($storeResult['status'] ==true){
                                        $user = Auth::user();
                                        // $files = Storage::files($this->claimPath.'/UN_AUDITED/');
                                        $department = Department::find(2); //Claim Enrty Department
                                        event(new ClaimFileUploaded([$storeResult['file']], $user->id, $department->id, $claim->id, 1));
                                    }
                                    $claim->processed = true;
                                    $claim->save();
                                    $excelfileError==false;
                                    //send push notification to users

                                    // event(new NewPushNotificationEvent("Claim Processed", "The claim with Claim ID: " . $claim->claimid . " has been been processed, pending auditing.", $claim->id));

                                }else{
                                    $excelfileError = true;
                                }

                            }else{
                                $excelfileError = true;
                            }                    
                    }else{
                        //store uploaded file
                        $storeResult = $this->storeFile($file, $unAuditedPath);
                        if($storeResult['status'] ==true){
                            $user = Auth::user();
                            // $files = Storage::files($this->claimPath.'/UN_AUDITED/');
                            $department = Department::find(2); //Claim Enrty Department
                            event(new ClaimFileUploaded([$storeResult['file']], $user->id, $department->id, $claim->id, 0));
                        }
                    }
                }

                if($excelfileError == false){
                    $company = $claim->company;
                    if($claim){
                        $claim->update([
                            'processed' =>  true, //check to make sure uploaded files contain excel 
                            'claim_directory' => $claimPath,
                            'head_directory' => $claimPath,
                            'department_reached' => 'Audit Department',
                            'claim_state_id' => 2
                        ]);
                    }
                    activity()
                        ->causedBy($user)
                        ->performedOn($claim)
                        ->withProperties(['company' => $company])
                        ->log(config('enums.CLAIM_FILES_UPLOADED'), config('enums.CLAIM_FILES_UPLOADED'));
                    
                    return response()->json([
                            'status' => 'success',
                            'message' => 'Processed claim file(s) uploaded successfully',
                    ]);
                }else{
                    $claim->update([
                        'processed' =>false,
                        'claim_directory' => $claimPath,
                        'head_directory' => $claimPath,
                    ]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unable to read Excel file. Please check the excel file and upload it again'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please upload processed files to update claim state'
                ]);
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to upload processed files. Please try again'
            ]);
        }
    }

    public function storeFile($file, $mainPath){
        try{
            $filename = time().$file->getClientOriginalName();
            // $storageDestinationPath= storage_path($mainPath);
            // if (!File::exists( $storageDestinationPath)) {
            //     File::makeDirectory($storageDestinationPath, 0755, true);
            // }
            $path = Storage::putFileAs(
                $mainPath,
                $file,
                $filename
            );
            return [
                'status' => true,
                'file' => $path
            ];
        }catch(Exception $e){
            Log::error($e);
            return [
                'status' => false,
                'file'=> null
            ];
        }
    }

    public function validateData(array $columns ){
           
        $validated = ["NO", "POLICY NUMBER", "CLAIMANT", "TYPE OF CLAIM", "AMOUNT(GHC)", "DATE", "COMPANY"];
        $intersect = array_intersect($validated, $columns);

        if(count($validated) == count($intersect)){
            return true;
        }else{
            return false;
        }
    }



    public function saveRequestFiles(Request $request){
        try{
             //create claim
             $claim = Claim::where('claimid', $request->claimid)->first();
             $user = Auth::user();

             if(!$claim){
                 return response()->json([
                     'status' => 'error',
                     'message' => 'Claim not found. Please try again'
                 ]);
             }

             //upload file
             $files = $request->file('claimfiles');


             //extract store claim zip file
             // $result =  $this->claimRepository->storeClaimFiles($uploadedFiles,strtoupper(str_replace(' ','_',$claim->company->name)), $claim->id, $claim->scheme_id, 1);
             
             // $claim->processed = $claim->processed == 1 ? $claim->processed : (int)$claimstate;
             // $claim->save();

             $claimPath = '';
             $unAuditedPath = '';
             $schemeid = $claim->scheme_id;
             $companyName = $claim->company->name;

            if($claim->claim_directory == null || $claim->claim_directory == ""){
                 $folder = (new DateTime())->format('Y_m_d');
                 $month = Carbon::now()->isoFormat('MMMM');
                 $year = Carbon::now()->isoFormat('Y');
                 $scheme = Scheme::find($schemeid);
                 $claimPath = 'files/'.$year.'/'.$month.'/'.$folder.'/'.$scheme->name.'/'.$companyName.'/'.$claim->claimid.'/';
                 $unAuditedPath = $claimPath."/UN_AUDITED/";
            }else{
                 $scheme = Scheme::find($schemeid);
                 $claimPath = $claim->claim_directory;
                 $unAuditedPath = $claimPath.'/UN_AUDITED/';
            }

            foreach($files as $file){
                    //store uploaded file
                $storeResult = $this->storeFile($file, $unAuditedPath);

                if($storeResult['status'] ==true){
                    $department = Department::find(2); //Claim Enrty Department
                    event(new ClaimFileUploaded([$storeResult['file']], $user->id, $department->id, $claim->id, 1));
                }
            }



            $company = $claim->company;
            activity()->causedBy($user)
                    ->performedOn($claim)
                    ->withProperties(['company' => $company])
                    ->log(config('enums.CLAIM_FILES_UPLOADED'), config('enums.CLAIM_FILES_UPLOADED'));
                    
            $claim->update([
                'processed' =>false,
                'claim_directory' => $claimPath,
                'head_directory' => $claimPath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Request files successfully uploaded'
            ]);

        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to upload request files. Please try again'
            ]);
        }
    }


    public function deleteClaim(Request $request){
        try{
            $claim = Claim::find($request->id);
            $claim->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Claim successfully deleted.'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete claim. Please try again'
            ]);
        }
    }




    public function claimDetails(Request $request) {
        $id = $request->query('claimid', null);
        if($id == null){
            return back()->with('error', 'Claim with ID: '. $id. ' not found');
        }
        $claim = Claim::where('claimid', $id)->with('scheme', 'company', 'claim_state')->first();

        $activities = Activity::where('subject_id', $claim?->id)->orderBy('created_at', 'DESC')->get();

        $employeeCount = Customer::where('claim_id', $claim->id)->count();

        $pendingIssues = Issue::where('claim_id', $claim->id)->get();

        return view('claims.singleclaim', compact('claim', 'activities', 'employeeCount', 'pendingIssues'));
    }


    public function deleteClaimFile(Request $request){
        $claimFile = ClaimFile::find($request->id);
        if($claimFile){

            $claim = Claim::find($claimFile->claim_id);
           
            $company = $claim->company;
            $user = Auth::user();
            activity()
                ->causedBy($user)
                ->performedOn($claim)
                ->withProperties(['company' => $company])
                ->log(config('enums.CLAIM_FILE_DELETED'), config('enums.CLAIM_FILE_DELETED'));
               
                
            $claimFile->delete();


            return response()->json([
                'status' => 'success',
                'message' => 'Claim file has been deleted.'
            ]);
            
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Ooops, Unable to delete file. File record not found.'
            ]);
        }
    }
}
