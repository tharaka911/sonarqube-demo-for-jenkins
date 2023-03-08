<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class CommandController extends Controller
{

    private $host;

    public function __construct()
    {
        $this->middleware('auth');
        $this->host = env('MEDIA_FILES_COLLECTOR_SCRIPT');
    }

    public function testPythonScript()
        {
            $type = "type1";
            $status = "active";
            $baseUrl = "url";
            $argv = $type. ",". $status . "," .$baseUrl;
            $test = "hello11"; 

            $process = new Process(['python3', 'test.py', $argv,$test]);
            $process->run();
            
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $data = $process->getOutput();

            dd($data);
        }

        public function collectMediaFiles()
        {
            $argv = $type. ",". $status . "," .$baseUrl;

            $process = new Process(['python3', 'test.py']);
            $process->run();
            
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $data = $process->getOutput();

            dd($data);
        }

        public function createPlayListXML()
        {
            $process = new Process(['python3', 'test.py']);
            $process->run();
            
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $data = $process->getOutput();

            dd($data);
        }

}
