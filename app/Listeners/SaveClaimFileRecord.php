<?php

namespace App\Listeners;

use App\Events\ClaimFileUploaded;
use App\Models\ClaimFile;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveClaimFileRecord
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
        foreach($event->files as $file){
            $claimfile = ClaimFile::where('filename', $file)->first();
            if(!$claimfile){
                $fileParts =  explode(".", $file);
                $extension = $fileParts[count($fileParts)-1];
                ClaimFile::create([
                    'user_id' => $event->userid,
                    'filename' => $file,
                    'month' => Carbon::now()->isoFormat('MMMM'),
                    'foldername' => (new DateTime())->format('Y_m_d'),
                    'department_id' => $event->departmentid,
                    'claim_id' => $event->claimid,
                    'extension' => $extension,
                    'is_processed_file' => $event->isprocessedfile
                ]);
            }
        }
    }
}
