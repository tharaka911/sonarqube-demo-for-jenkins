<?php

namespace App\Service\CommandService;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PythonScriptRunnerService
{
   function generatePlaylist($baseUrl, $savePath, $count, $waitingVideoUrl, $id){

        $listRange = $count + 1;
        
        $process = new Process(['python3', 'scripts/playlist_generator.py', $baseUrl,$savePath,$listRange,$waitingVideoUrl, $id]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);
        $process->run();
        
        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'invalid'], 401);
            throw new ProcessFailedException($process);
        }else{
            $data = $process->getOutput();
            return response()->json(['success' => 'success'], 200);
        }

   }

   public function replaceTrack($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID)
   {
        $process = new Process(['python3', 'scripts/replace_track.py',$selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'invalid'], 401);
            throw new ProcessFailedException($process);
        }else{
            $data = $process->getOutput();
            return response()->json(['success' => 'success'], 200);
        }
   }


   public function copyFile($sourceFilePath,$destinationFilePath,$destinationFilePathDir)
   {
        $process = new Process(['python3', 'scripts/file_copy.py',$sourceFilePath,$destinationFilePath,$destinationFilePathDir]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'invalid'], 401);
            throw new ProcessFailedException($process);
        }else{
            $data = $process->getOutput();
            return response()->json(['success' => 'success'], 200);
        }
   }

   public function deleteFile($filePath)
   {
        $process = new Process(['python3', 'scripts/file_delete.py',$filePath]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'invalid'], 401);
            throw new ProcessFailedException($process);
        }else{
            $data = $process->getOutput();
            return response()->json(['success' => 'success'], 200);
        }
   }

   public function deleteFolder($filePath)
   {
        $process = new Process(['python3', 'scripts/folder_delete.py',$filePath]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'invalid'], 401);
            throw new ProcessFailedException($process);
        }else{
            $data = $process->getOutput();
            return response()->json(['success' => 'success'], 200);
        }
   }

//    public function videoListSync()
//    {

//         $process = new Process(['python3', 'scripts/videolist_update.py']);
//         $process->run();

//         if (!$process->isSuccessful()) {
//             return response()->json(['error' => 'invalid'], 401);
//             //throw new ProcessFailedException($process);
//         }else{
//             $data = $process->getOutput();
//             return response()->json(['success' => 'success'], 200);
//         }
//    }


    
}

?>