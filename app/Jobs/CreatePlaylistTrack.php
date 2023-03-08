<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Service\CommandService\PythonScriptRunnerService;

class CreatePlaylistTrack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $selectedVideoFilePath = null;
    private $playlistTrackIds = null;
    private $sourcePath = null;
    private $tempPath = null;
    private $destinationPath = null;
    private $playlistID = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID)
    {
        $this->selectedVideoFilePath = $selectedVideoFilePath;
        $this->playlistTrackIds = $playlistTrackIds;
        $this->sourcePath = $sourcePath;
        $this->tempPath = $tempPath;
        $this->destinationPath = $destinationPath;
        $this->playlistID = $playlistID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $PythonScriptRunnerService = new PythonScriptRunnerService();
            
        $PythonScriptRunnerService->replaceTrack($this->selectedVideoFilePath,$this->playlistTrackIds,$this->sourcePath,$this->tempPath,$this->destinationPath,$this->playlistID);

    }
}
