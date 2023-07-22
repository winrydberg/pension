<?php

namespace App\Listeners;

use App\Events\ClaimFileUploaded;
use App\Imports\CustomersImport;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReadCustomerRecordToDB
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClaimFileUploaded $event): void
    {
        //1. find the uploaded excel file
        //2. read the file
        foreach($event->files as $file){
            try{
                $parts = explode(".",$file);
                $extension = $parts[count($parts)-1];
                if(in_array($extension, ['xls', 'xlsx'])){
                    
                    Excel::import(new CustomersImport($event->claimid), storage_path("app/".$file));
                }
            }catch(Exception $e){
                //todo - dispatch an import action
                Log::error("=============EXCEL FILE READING ERROR=============");
                Log::error($e->getMessage());
                Log::error($e);
                Log::error("=============EXCEL FILE READING ERROR=============");
            }
            
        }
    }
}
