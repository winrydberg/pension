<?php

namespace App\Http\Controllers;

use App\Events\ClaimDownloaded;
use App\Models\Claim;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class DownloadController extends Controller
{
    public function downloadClaimFiles($id, $claimid){

        $claim = Claim::where('id',  $id)->first();
         if($claim){
            $zip = new ZipArchive();
            try{
                if($claim->claim_directory == null){
                    return redirect()->back()->with('error', 'Files Not Found. Upload files for claim');
                }
                // $name = 'CLAIM_ID_'.$claim->claimid.'_FILES.zip';
                $name = strtoupper($claim->description).'_'.time().'_FILES.zip';

                // if(($zip->open(public_path($name), ZipArchive::CREATE)==TRUE)){
                //     $storePath = storage_path('app/files/downloads/'.$name);
                //     $filesPath = storage_path('app/'.$claim->claim_directory);

                //     if (!File::exists(storage_path('app/files/downloads/'))) {
                //         File::makeDirectory(storage_path('app/files/downloads/'), 0755, true);
                //     }
                //     $zip = new \ZipArchive();
                
                //     if ($zip->open($storePath, \ZipArchive::CREATE) !== true) {
                //         throw new \RuntimeException('Cannot open ' . $storePath);
                //     }
                
                //     $this->addContent($zip, $filesPath);
                //     $zip->close();

                //     event(new ClaimDownloaded($claim));
                    
                //     return response()->download($storePath);
                // }else{
                //     return back();
                // }

                // Get real path for our folder
                // $rootPath = realpath('folder-to-zip');
                $rootPath = storage_path('app/'.$claim->claim_directory);
                $storePath = storage_path('app/files/downloads/'.$name);

                if (!File::exists(storage_path('app/files/downloads/'))) {
                    File::makeDirectory(storage_path('app/files/downloads/'), 0755, true);
                }

                // Initialize archive object
                $zip = new ZipArchive();
                $zip->open($storePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

                // Create recursive directory iterator
                /** @var SplFileInfo[] $files */
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($rootPath),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file)
                {
                    // Skip directories (they would be added automatically)
                    if (!$file->isDir())
                    {
                        // Get real and relative path for current file
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($rootPath) + 0);
                        // Add current file to archive
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                // Zip archive will be created only after closing object
                $zip->close();

                event(new ClaimDownloaded($claim));
                
                return response()->download($storePath);


            }catch(Exception $e){
                Log::error('====================DOWNLOAD ERROR=========================');
                Log::error($e->getMessage());
                Log::error('====================DOWNLOAD ERROR=========================');
                return redirect()->back()->with('error', 'Unable to download files. Files Not Found');
               
            }
        }else{
            return redirect()->back()->with('error', 'Claim Not Found');
        }
    }


    private function addContent(\ZipArchive $zip, string $path)
    {
        /** @var SplFileInfo[] $files */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::FOLLOW_SYMLINKS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    
        while ($iterator->valid()) {
            if (!$iterator->isDot()) {
                $filePath = $iterator->getPathName();
                $relativePath = substr($filePath, strlen($path) + 1);
    
                if (!$iterator->isDir()) {
                    $zip->addFile($filePath, $relativePath);
                } else {
                    if ($relativePath !== false) {
                        $zip->addEmptyDir($relativePath);
                    }
                }
            }
            $iterator->next();
        }
    }
}
