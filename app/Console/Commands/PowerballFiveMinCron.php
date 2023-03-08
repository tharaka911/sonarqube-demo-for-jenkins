<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class PowerballFiveMinCron extends Command
{
    private $host;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'powerballfivemin:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->host = env('WINNER_API_HOST');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $response = Http::post($this->host.'/powerball/post/liveball', [
            'type' => $request->get('total_amount'),
            'round' => $request->get('difference_amount'),
            'powerball' => $request->get('total_amount'),
            'normalball' => $request->get('difference_amount'),
            'result' => $request->get('total_amount'),
            'status' => $request->get('difference_amount'),
        ]);

        \Log::info("Five Min Cron is working fine!");
        //return 0;
    }
}
