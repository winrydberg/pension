<?php

namespace App\Http\Controllers;

use App\Events\ClaimFileUploaded;
use App\Events\IssueResolved;
use App\Events\NewIssueRaised;
use App\Models\Claim;
use App\Models\ClaimFile;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Issue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IssueController extends Controller
{
    public function reportIssueOnClaimFile(Request $request){
        try{
            $claimfile = ClaimFile::find($request->id);
            if($claimfile){
                if($claimfile->issue_id != null){
                    $issue = Issue::find($claimfile->issue_id);
                    if($issue && $issue->resolved ==false){
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Oops File already has unresolved issue. Issue on current file must be resolved to raise new issue on file'
                        ]);
                    }
                }
                $claim = Claim::find($claimfile->claim_id);
                $random = substr(md5(mt_rand()), 0 , 7);
                $issueticket = $random.''.mt_rand(1000, 9999);
                $data = [];
                $data['issue_ticket'] = strtoupper($issueticket);
                $data['resolved'] = false;
                $data['message'] = $request->message;
                $data['claim_file_id'] = $claimfile->id;
                $data['claim_id'] = $claimfile->claim_id;
                $data['department_id'] = Auth::user()->department_id;
                $issue = Issue::create($data);

                event(new NewIssueRaised($issue));

                $claimfile->update([
                    'issue_id' => $issue->id
                ]);

                $claim->update([
                    'has_issue' => true
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Issue successfully reported on file.'
                ]);

            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unable to report issue. Claim File NOT found.'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Oops, unable to file issue on claim file. Please try again.'
            ]);
        }
    }


    public function reviewIssue(Request $request){
        $issue = Issue::where('issue_ticket', $request->query('ticket', null))->with('claim')->first();
        if($issue == null){
            return back()->with('error', 'Issue with ticket'.$request->query('ticket', null).' not found');
        }
        return view('issue.review', compact('issue'));
    }


    public function resolveIssue(Request $request){
        try{
            $issue = Issue::where('issue_ticket', $request->ticket)->first();
            if($issue){
                $user = Auth::user();
                $claim = Claim::find($issue->claim->id);

                $files = $request->file('claimfiles');
                
                if($files != null){
                    foreach($files as $file){
                        $this->storeIssueReviewFile($file, $issue);
                    }
                }
            
                $issue->update([
                    'resolved'=> true,
                    'resolve_message' => $request->resolve_message,
                    'user_id' => $user->id,
                    'review_files_directory' => $claim->claim_directory."/ISSUE_REVIEW/".date('Y_m_d')."/",
                ]);



                event(new IssueResolved($issue));

                
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Issue resolved successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Oops issue not found'
                ]);
            }
        }catch(Exception $e)
            {
                Log::error($e);
                return [
                    'status' => 'error',
                    'message' => 'Oops, Something went wrong. Please try again later'
                ];
            }
    }


    public function storeIssueReviewFile($file, $issue){
        $extension = $file->getClientOriginalExtension();
        $claim = Claim::find($issue->claim->id);
        $claimFile = ClaimFile::find($issue->claim_file_id);
        if( in_array(strtolower($extension) , ['xlsx', 'xls']) ){
            if($issue->claim_file_id != null){
                Storage::disk('local')->delete($claimFile->filename);
                $path = '';
                if($claim->audited){
                    $path = Storage::putFileAs(
                        $claim->claim_directory."/AUDITED/",
                        $file,
                        $file->getClientOriginalName()
                    );
                }else{
                    $path = Storage::putFileAs(
                         $claim->claim_directory.'/UN_AUDITED/',
                        $file,
                        $file->getClientOriginalName()
                    );
                }
                $claimFile = ClaimFile::find($issue->claim_file_id);
                if($claimFile){
                 
                    $claimFile->update([
                        'filename' => $path,
                        'extension' => $extension
                    ]);
                }
                $user = Auth::user();
                
                // $files = Storage::files($this->claimPath.'/UN_AUDITED/');
                $department = Department::find(Auth::user()->department_id); //Claim Enrty Department

                //remove old data
                Customer::where('claim_id', $claim->id)->delete();

                $claim->update([
                    'processed' => true,
                    'claim_amount' => null
                ]);
                $issue->update([
                    'resolved' => true
                ]);
                event(new ClaimFileUploaded([$path], $user->id, $department->id, $claim->id, 1));   

            }else{
                $uploadPath = $claim->claim_directory.'/ISSUE_REVIEW_FILES';
                // $storageDestinationPath= storage_path('app/'.$uploadPath);
                // if (!File::exists( $storageDestinationPath)) {
                //     File::makeDirectory($storageDestinationPath, 0755, true);
                // }
                $path = Storage::putFileAs(
                    $uploadPath,
                    $file,
                    $file->getClientOriginalName()
                );
            } 
        }else{
            //1. check if issue has claim file
            if($issue->claim_file_id != null){

                if($claim->audited){

                    $path = Storage::putFileAs(
                        $claim->claim_directory."/AUDITED/",
                        $file,
                        $file->getClientOriginalName()
                    );

                    //find claim file and remove it from DB and storage
                    $claimFile = ClaimFile::find($issue->claim_file_id);

                    if($claimFile){
                        // $claimFile->delete();
                        Storage::disk('local')->delete($claimFile->filename);
                        $claimFile->update([
                            'filename' => $path,
                            'extension' => $extension
                        ]);
                    }

                }else{
                    $path = Storage::putFileAs(
                         $claim->claim_directory.'/UN_AUDITED/',
                        $file,
                        $file->getClientOriginalName()
                    );

                    //find claim file and remove it from DB and storage
                    $claimFile = ClaimFile::find($issue->claim_file_id);

                    if($claimFile){
                        // $claimFile->delete();
                        Storage::disk('local')->delete($claimFile->filename);
                        $claimFile->update([
                            'filename' => $path,
                            'extension' => $extension
                        ]);
                    }
                }
                
            }else{
                $path = Storage::putFileAs(
                        $claim->claim_directory."/ISSUE_REVIEW/".date('Y_m_d')."/",
                        $file,
                        $file->getClientOriginalName()
                );
                //find claim file and remove it from DB and storage
                $claimFile = ClaimFile::find($issue->claim_file_id);
                if($claimFile){
                    // $claimFile->delete();
                    Storage::disk('local')->delete($claimFile->filename);
                    $claimFile->update([
                        'filename' => $path,
                        'extension' => $extension
                    ]);
                }
            }
                            
                            
        }
    }

    public function getClaimsWithIssue(){
        $claims = Claim::where('has_issue', true)->get();
        return view('issue.claimswithissue', compact('claims'));
    }
}
