<?php

namespace App\Http\Controllers;

use App\Balancing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use App\Service\CommandService\PythonScriptRunnerService;
use App\ThreeMinVideoList;
use App\FiveMinVideoList;
use App\Playlist;
use App\PlaylistTrack;
use App\BalancingData;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Mockery\Undefined;
use App\Events\BalancingDataWasReceived;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;

class BalancingController extends Controller
{

    private $obsSocketApiThreeMin;
    private $obsSocketApiFiveMin;
    private $winnerAPI;
    private $sourcePath;
    private $tempPath;
    private $destinationPath;
    private $ipCheck;
    private $bepickhost;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->winnerAPI = env('WINNER_API_HOST');
        $this->obsSocketApiThreeMin = env('OBS_SOCKET_API_THREE_MIN');
        $this->obsSocketApiFiveMin = env('OBS_SOCKET_API_FIVE_MIN');
        $this->sourcePath = env('SOURCE_PATH');
        $this->tempPath = env('TEMP_PATH');
        $this->destinationPath = env('DESTINATION_PATH');
        $this->ipCheck = env('IP_CHECK');
        $this->bepickhost = env('BEPICK_API_HOST');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function checkIP(Request $request)
    {
        $ip = $request->getClientIp();
        dd($ip);
        $response = Http::get($this->winnerAPI.'apiKey/list');
        $response = $response->json();
        $ipList = $response['data']['result'];
        $collection = collect($ipList);

        if($collection->where('ip', '192.168.1.3')->isNotEmpty()) {
            return "sdasd";
            // The value "Jane" exists in the collection
        }else {
            return "ioi";
            // The value "Jane" does not exist in the collection
        }
        return $response;


    }

    public function index(Request $request, $type)
    {
        if($type == "3min"){
            $interval = 3;
        }
        if($type == "5min"){
            $interval = 5;
        }

        $date = Carbon::now()->format('Y-m-d');
        $liveball_results = Http::get($this->winnerAPI . 'powerball/get/liveball/today?type='.$interval)->json();
        $liveball_results = $liveball_results["data"]["data"];

        $balancing = DB::table('balancings')->where('status',1)->where('stream_type',$type)->first();

        $single_balancing = DB::table('single_balancing')->where('type',$type)->get();
        $combine_balancing = DB::table('combine_balancing')->where('type',$type)->get();

        return view('dashboard.balancing')->with('balancing',$balancing)->with('liveball_results',$liveball_results)->with("winnerAPI",$this->winnerAPI)->with("type",$type)->with("date",$date)
        ->with('single_balancing',$single_balancing)->with('combine_balancing',$combine_balancing);
    }

    public function addView(Request $request)
    {
        return view('dashboard.add_balancing');
    }

    public function fatherSiteBalancing($type)
    {
        $father_site_data = DB::table('balancing_data')->where('type',$type)->orderBy('id', 'DESC')->get();

        return view('dashboard.father_site_balancing')->with('father_site_data',$father_site_data)->with('type',$type);
    }

    public function sendBalancingData(Request $request,$type){

        if($type=="3min"){
            $type_id = "3";
        }
        if($type=="5min"){
            $type_id = "5";
        }

        $current_round = Http::get($this->winnerAPI . "powerball/get_liveball/next_round?type=$type_id")->json();

        $round = $current_round["data"]["round"];
        $date = $current_round["data"]["date"];

        $result = DB::select("SELECT '$type' AS 'type', SUM(pb_odd) AS pb_odd, SUM(pb_even) AS pb_even, SUM(pb_under) AS pb_under, SUM(pb_over) AS pb_over, SUM(nb_odd) AS nb_odd, SUM(nb_even) AS nb_even, SUM(nb_under) AS nb_under, SUM(nb_over) AS nb_over, SUM(nb_large) AS nb_large,SUM(nb_medium) AS nb_medium,SUM(nb_small) AS nb_small,SUM(pb_odd_under) AS pb_odd_under,SUM(pb_odd_over) AS pb_odd_over,SUM(pb_even_under) AS pb_even_under,SUM(pb_even_over) AS pb_even_over,SUM(nb_odd_under) AS nb_odd_under, SUM(nb_odd_over) AS nb_odd_over,SUM(nb_even_under) AS nb_even_under,SUM(nb_even_over) AS nb_even_over,SUM(nb_odd_large) AS nb_odd_large,SUM(nb_odd_medium) AS nb_odd_medium,SUM(nb_odd_small) AS nb_odd_small, SUM(nb_even_large) AS nb_even_large,SUM(nb_even_medium) AS nb_even_medium,SUM(nb_even_small) AS nb_even_small FROM balancing_data WHERE date = '$date' AND type = '$type' AND round = '$round'")[0];

        //$result = DB::table('balancing_data')->where('type',$type)->first();

        event(new BalancingDataWasReceived($result));

    }

    public function bepikAPI($gametype)
    {

        $response = Http::get($this->bepickhost.$gametype);

        $data = $response->json();
        return $data;

    }

    public function balancingSpecific(Request $request)
    {
        /**
         * Save function call time
         */
        $callTime = new \DateTime();

        /**
         * Check IP
         */
        // $ip = $request->getClientIp();
        // $response = Http::get($this->winnerAPI.'apiKey/list');
        // $response = $response->json();
        // $ipList = $response['data']['result'];
        // $collection = collect($ipList);

        // if($this->ipCheck == "ip_check"){

        //     if(!$collection->where('ip', $ip)->isNotEmpty()) {
        //         return response()->json(['response' => 'fail']);
        //     }
        // }

        $type = $request->get('type');

        if($type=="3min"){
            $type_id = "3";
        }elseif($type=="5min"){
            $type_id = "5";
        }else{
            return response()->json("Type is wrong. Please try again", 400);
        }

        // $current_round = Http::get($this->winnerAPI . "powerball/get_liveball/next_round?type=$type_id")->json();

        // $round = $current_round["data"]["round"];
        // $date = $current_round["data"]["date"];


        try{

            if($type=="3min"){
                $obs_api = Http::get($this->obsSocketApiThreeMin . 'api/current_video')->json();
            }elseif($type=="5min"){
                $obs_api = Http::get($this->obsSocketApiFiveMin . 'api/current_video')->json();
            }else{
                return response()->json("Type is wrong. Please try again", 400);
            }

            $current_playlist_id=$obs_api["data"]["playlist_id"];
            $current_track_id=$obs_api["data"]["next_track_id"];

            if(!is_numeric($current_track_id)){
                return response()->json("Please try again",400);
            }

            $playlistID=$current_playlist_id;

            $playlistTrackIdsArray = explode(",",$current_track_id);
            $playlistTrackIds = json_encode($playlistTrackIdsArray);

            /**
             * Normalball
             */

            if($request->get('normalball_under_over')=="under"){
                $normalball_under_over = '<=';
            }

            if($request->get('normalball_under_over')=="over"){
                $normalball_under_over = '>';
            }

            if($request->get('normalball_odd_even')=="odd"){
                $normalball_odd_even = '!=';
            }

            if($request->get('normalball_odd_even')=="even"){
                $normalball_odd_even = '=';
            }

            $normalball_size = $request->get('normalball_size');

            if($normalball_size == "small"){
                $normalball_size_array = [15,64];
            }

            if($normalball_size == "medium"){
                $normalball_size_array = [65,80];
            }

            if($normalball_size == "large"){
                $normalball_size_array = [81,130];
            }

            /**
             * Powerball
             */

            if($request->get('powerball_under_over')=="under"){
                $powerball_under_over = '<=';
            }

            if($request->get('powerball_under_over')=="over"){
                $powerball_under_over = '>';
            }

            if($request->get('powerball_odd_even')=="odd"){
                $powerball_odd_even = '!=';
            }

            if($request->get('powerball_odd_even')=="even"){
                $powerball_odd_even = '=';
            }

            $selectedVideoFilePath = array();

                for ($i=0; $i < count($playlistTrackIdsArray); $i++) {

                    if($type == "3min"){
                        $newTrackVideo = ThreeMinVideoList::whereRaw("(normalball % 2) $normalball_odd_even 0")->where('normalball', $normalball_under_over , 72)
                        ->whereRaw("(powerball % 2) $powerball_odd_even 0")->where('powerball', $powerball_under_over , 4)->whereBetween('normalball', $normalball_size_array)->where('updated_at', '<', Carbon::now()->subDays(5))->inRandomOrder()->first();

                    }
                    if($type == "5min"){
                        $newTrackVideo = FiveMinVideoList::whereRaw("(normalball % 2) $normalball_odd_even 0")->where('normalball', $normalball_under_over , 72)
                        ->whereRaw("(powerball % 2) $powerball_odd_even 0")->where('powerball', $powerball_under_over , 4)->whereBetween('normalball', $normalball_size_array)->where('updated_at', '<', Carbon::now()->subDays(5))->inRandomOrder()->first();
                    }

                    if(is_null($newTrackVideo) ){
                        return response()->json("No matching videos", 400);
                    }

                    $newTrackVideo->count = $newTrackVideo->count+1;
                    $newTrackVideo->save();

                    array_push($selectedVideoFilePath,$newTrackVideo->file_path);

                    //$playlistID=$request->get('playlist_id');
                    $currentTrackID=$playlistTrackIdsArray[$i];
                    $newVideoID=$selectedVideoFilePath[$i];

                    //$playlistTrack = PlaylistTrack::find($currentTrackID);

                    $playlistTrack = PlaylistTrack::where('playlist_id',$playlistID)->where('track_id',$playlistTrackIdsArray[$i])->first();

                    $playlistTrack->video_id =  $newTrackVideo->id;
                    $playlistTrack->save();
                }

                $selectedVideoFilePath = json_encode($selectedVideoFilePath);

                $sourcePath = $this->sourcePath;
                $tempPath = $this->tempPath;
                $destinationPath = $this->destinationPath.$type.'/' . $playlistID . '/';

                $PythonScriptRunnerService = new PythonScriptRunnerService();
                $PythonScriptRunnerService->replaceTrack($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID);

                return response()->json(['response' => 'success']);
                /**
                 * Save function call time, finish time and result in the database
                 */

                $finishTime = new \DateTime();
                $callTimeFormatted = $callTime->format('Y-m-d H:i:s');
                $finishTimeFormatted = $finishTime->format('Y-m-d H:i:s');

                DB::table('balancing_specifics')
                    ->insert([
                        'call_time' => $callTimeFormatted,
                        'result' => $newTrackVideo->id,
                        'finish_time' => $finishTimeFormatted
                    ]);

        }catch(\Exception $error){
            return response()->json("Something goes wrong. Please try again", 400);
        }

    }

    public function balancingFatherData(Request $request)
    {
        /**
         * Check IP
         */
        $ip = $request->getClientIp();
        $response = Http::get($this->winnerAPI.'apiKey/list');
        $response = $response->json();
        $ipList = $response['data']['result'];
        $collection = collect($ipList);

        if($this->ipCheck == "ip_check"){

            if(!$collection->where('ip', $ip)->isNotEmpty()) {
                return response()->json(['response' => 'fail']);
            }
        }

        $type = $request->get('type');

        if($type=="3min"){
            $type_id = "3";
        }
        if($type=="5min"){
            $type_id = "5";
        }

        $current_round = Http::get($this->winnerAPI . "powerball/get_liveball/next_round?type=$type_id")->json();

        $round = $current_round["data"]["round"];
        $date = $current_round["data"]["date"];

        $powerball_bet_amount_odd = $request->get('powerball_bet_amount_odd');
        $powerball_bet_amount_even = $request->get('powerball_bet_amount_even');
        $powerball_bet_amount_under = $request->get('powerball_bet_amount_under');
        $powerball_bet_amount_over = $request->get('powerball_bet_amount_over');

        $normalball_bet_amount_odd = $request->get('normalball_bet_amount_odd');
        $normalball_bet_amount_even = $request->get('normalball_bet_amount_even');
        $normalball_bet_amount_under = $request->get('normalball_bet_amount_under');
        $normalball_bet_amount_over = $request->get('normalball_bet_amount_over');

        $normalball_bet_amount_large = $request->get('normalball_bet_amount_large');
        $normalball_bet_amount_medium = $request->get('normalball_bet_amount_medium');
        $normalball_bet_amount_small = $request->get('normalball_bet_amount_small');

        $powerball_bet_amount_odd_under = $request->get('powerball_bet_amount_odd_under');
        $powerball_bet_amount_odd_over = $request->get('powerball_bet_amount_odd_over');
        $powerball_bet_amount_even_under = $request->get('powerball_bet_amount_even_under');
        $powerball_bet_amount_even_over = $request->get('powerball_bet_amount_even_over');

        $normalball_bet_amount_odd_under = $request->get('normalball_bet_amount_odd_under');
        $normalball_bet_amount_odd_over = $request->get('normalball_bet_amount_odd_over');
        $normalball_bet_amount_even_under = $request->get('normalball_bet_amount_even_under');
        $normalball_bet_amount_even_over = $request->get('normalball_bet_amount_even_over');

        $normalball_bet_amount_odd_large = $request->get('normalball_bet_amount_odd_large');
        $normalball_bet_amount_odd_medium = $request->get('normalball_bet_amount_odd_medium');
        $normalball_bet_amount_odd_small = $request->get('normalball_bet_amount_odd_small');
        $normalball_bet_amount_even_large = $request->get('normalball_bet_amount_even_large');
        $normalball_bet_amount_even_medium = $request->get('normalball_bet_amount_even_medium');
        $normalball_bet_amount_even_small = $request->get('normalball_bet_amount_even_small');

        try{

            $balancing_data=array('type'=>$type,'ip'=>$ip,'round'=>$round,'date'=>$date,'pb_odd'=>$powerball_bet_amount_odd,"pb_even"=>$powerball_bet_amount_even,"pb_under"=>$powerball_bet_amount_under,"pb_over"=>$powerball_bet_amount_over,
            'nb_odd'=>$normalball_bet_amount_odd,"nb_even"=>$normalball_bet_amount_even,"nb_under"=>$normalball_bet_amount_under,"nb_over"=>$normalball_bet_amount_over,
            'nb_large'=>$normalball_bet_amount_large,"nb_medium"=>$normalball_bet_amount_medium,"nb_small"=>$normalball_bet_amount_small,'pb_odd_under'=>$powerball_bet_amount_odd_under,"pb_odd_over"=>$powerball_bet_amount_odd_over,"pb_even_under"=>$powerball_bet_amount_even_under,"pb_even_over"=>$powerball_bet_amount_even_over,
            'nb_odd_under'=>$normalball_bet_amount_odd_under,"nb_odd_over"=>$normalball_bet_amount_odd_over,"nb_even_under"=>$normalball_bet_amount_even_under,"nb_even_over"=>$normalball_bet_amount_even_over,
            'nb_odd_large'=>$normalball_bet_amount_odd_large,"nb_odd_medium"=>$normalball_bet_amount_odd_medium,"nb_odd_small"=>$normalball_bet_amount_odd_small,
            'nb_even_large'=>$normalball_bet_amount_even_large,"nb_even_medium"=>$normalball_bet_amount_even_medium,"nb_even_small"=>$normalball_bet_amount_even_small);

            DB::table('balancing_data')->insert($balancing_data);

            return response()->json(['response' => 'success']);

        }catch(\Exception $error){

            return response()->json(['response' => 'fail']);
        }
    }

    public function filterByDate(Request $request){
        $type = $request->get('type');
        $date = $request->get('date');

        if($type == "3min"){
            $interval = 3;
        }
        if($type == "5min"){
            $interval = 5;
        }

        $liveball_results = Http::get($this->winnerAPI . '/powerball/getByDate?type='.$interval.'&date='.$date)->json();
        $liveball_results = $liveball_results["data"]["data"];
        //dd($liveball_results);
        $balancing = DB::table('balancings')->where('status',1)->where('stream_type',$type)->first();
        return redirect()->back();
        //return redirect()->back()->with('balancing',$balancing)->with('liveball_results',$liveball_results)->with("type",$type)->with("date",$date);
        //return view('dashboard.balancing')->with('balancing',$balancing)->with('liveball_results',$liveball_results)->with("type",$type)->with("date",$date);

    }

    /**
     * Bancing according to mother site results
     */

    public function balancing(Request $request)
    {

        $type = $request->get('type');

        if($type=="3min"){
            $type_id = "3";
        }elseif($type=="5min"){
            $type_id = "5";
        }else{
            return response()->json("Type is wrong. Please try again", 400);
        }

        $current_round = Http::get($this->winnerAPI . "powerball/get_liveball/next_round?type=$type_id")->json();

        $round = $current_round["data"]["round"];
        $date = $current_round["data"]["date"];

        try{
            if($type=="3min"){
                $obs_api = Http::get($this->obsSocketApiThreeMin . 'api/current_video')->json();
            }elseif($type=="5min"){
                $obs_api = Http::get($this->obsSocketApiFiveMin . 'api/current_video')->json();
            }else{
                return response()->json("Type is wrong. Please try again", 400);
            }

            $current_playlist_id=$obs_api["data"]["playlist_id"];
            $current_track_id=$obs_api["data"]["next_track_id"];

            if(!is_numeric($current_track_id)){
                return response()->json("Please try again",400);
            }

            /**
             * Get form OBS Result API
             */
            $playlistTrackIds = json_encode(array($current_track_id));

            $playlistTrackIdsArray=array($current_track_id);
            $playlistID=$current_playlist_id;

            /**
             * Static probability
             */
            $filter = ["=","!="];

            $powerball_multiplier = 1.95;
            $normalball_multiplier = 1.95;
            $normalball_sum_multiplier = 2.4;

            $powerball_combination_multiplier_odd_under = 4.12;
            $powerball_combination_multiplier_odd_over = 3.02;
            $powerball_combination_multiplier_even_under = 3.02;
            $powerball_combination_multiplier_even_over = 4.12;

            $normalball_combination_multiplier = 3.7;

            $normalball_combination_multiplier_odd_small = 4.4;
            $normalball_combination_multiplier_odd_medium = 4.2;
            $normalball_combination_multiplier_odd_large = 4.4;
            $normalball_combination_multiplier_even_small = 4.4;
            $normalball_combination_multiplier_even_medium = 4.2;
            $normalball_combination_multiplier_even_large = 4.4;

            $under = [15, 72];
            $over = [73, 130];
            $small = [15,64];
            $medium = [65,80];
            $large = [81,130];

            $pb_under = [0, 4];
            $pb_over = [5, 9];

            $pb_range = [0, 9];
            $nb_range = [0, 130];
            $pb_oe_flag = 0;
            $pb_uov_flag = 0;
            $nb_oe_flag = 0;
            $nb_uov_flag = 0;
            $nb_lms_flag = 0;

            // $powerball_bet_amount_odd = $request->get('powerball_bet_amount_odd');
            // $powerball_bet_amount_even = $request->get('powerball_bet_amount_even');
            // $powerball_bet_amount_under = $request->get('powerball_bet_amount_under');
            // $powerball_bet_amount_over = $request->get('powerball_bet_amount_over');

            // $normalball_bet_amount_odd = $request->get('normalball_bet_amount_odd');
            // $normalball_bet_amount_even = $request->get('normalball_bet_amount_even');
            // $normalball_bet_amount_under = $request->get('normalball_bet_amount_under');
            // $normalball_bet_amount_over = $request->get('normalball_bet_amount_over');

            // $normalball_bet_amount_large = $request->get('normalball_bet_amount_large');
            // $normalball_bet_amount_medium = $request->get('normalball_bet_amount_medium');
            // $normalball_bet_amount_small = $request->get('normalball_bet_amount_small');

            // $powerball_bet_amount_odd_under = $request->get('powerball_bet_amount_odd_under');
            // $powerball_bet_amount_odd_over = $request->get('powerball_bet_amount_odd_over');
            // $powerball_bet_amount_even_under = $request->get('powerball_bet_amount_even_under');
            // $powerball_bet_amount_even_over = $request->get('powerball_bet_amount_even_over');

            // $normalball_bet_amount_odd_under = $request->get('normalball_bet_amount_odd_under');
            // $normalball_bet_amount_odd_over = $request->get('normalball_bet_amount_odd_over');
            // $normalball_bet_amount_even_under = $request->get('normalball_bet_amount_even_under');
            // $normalball_bet_amount_even_over = $request->get('normalball_bet_amount_even_over');

            // $normalball_bet_amount_odd_large = $request->get('normalball_bet_amount_odd_large');
            // $normalball_bet_amount_odd_medium = $request->get('normalball_bet_amount_odd_medium');
            // $normalball_bet_amount_odd_small = $request->get('normalball_bet_amount_odd_small');
            // $normalball_bet_amount_even_large = $request->get('normalball_bet_amount_even_large');
            // $normalball_bet_amount_even_medium = $request->get('normalball_bet_amount_even_medium');
            // $normalball_bet_amount_even_small = $request->get('normalball_bet_amount_even_small');

            $powerball_bet_amount_odd = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_odd");
            $powerball_bet_amount_even = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_even");
            $powerball_bet_amount_under = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_under");
            $powerball_bet_amount_over = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_over");

            $normalball_bet_amount_odd = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_odd");
            $normalball_bet_amount_even = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_even");
            $normalball_bet_amount_under = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_under");
            $normalball_bet_amount_over = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_over");

            $normalball_bet_amount_large = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_large");
            $normalball_bet_amount_medium = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_medium");
            $normalball_bet_amount_small = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_small");

            $powerball_bet_amount_odd_under = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_odd_under");
            $powerball_bet_amount_odd_over = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_odd_over");
            $powerball_bet_amount_even_under = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_even_under");
            $powerball_bet_amount_even_over = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("pb_even_over");

            $normalball_bet_amount_odd_under = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_odd_under");
            $normalball_bet_amount_odd_over = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_odd_over");
            $normalball_bet_amount_even_under = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_even_under");
            $normalball_bet_amount_even_over = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_even_over");

            $normalball_bet_amount_odd_large = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_odd_large");
            $normalball_bet_amount_odd_medium = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_odd_medium");
            $normalball_bet_amount_odd_small = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_odd_small");
            $normalball_bet_amount_even_large = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_even_large");
            $normalball_bet_amount_even_medium = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_even_medium");
            $normalball_bet_amount_even_small = DB::table('balancing_data')->where('type', $type)->where('round', $round)->where('date', $date)->sum("nb_even_small");

            /**
             * Get type of balancing
             */
            $balancing = DB::table('balancings')->where('status',1)->where('stream_type',$type)->first();

            if($balancing->balancing_type == "normal"){
                return response()->json("Normal Balancing",201);
            }

            // $balancing_data=array('type'=>$type,'pb_odd'=>$powerball_bet_amount_odd,"pb_even"=>$powerball_bet_amount_even,"pb_under"=>$powerball_bet_amount_under,"pb_over"=>$powerball_bet_amount_over,
            // 'nb_odd'=>$normalball_bet_amount_odd,"nb_even"=>$normalball_bet_amount_even,"nb_under"=>$normalball_bet_amount_under,"nb_over"=>$normalball_bet_amount_over,
            // 'nb_large'=>$normalball_bet_amount_large,"nb_medium"=>$normalball_bet_amount_medium,"nb_small"=>$normalball_bet_amount_small,'pb_odd_under'=>$powerball_bet_amount_odd_under,"pb_odd_over"=>$powerball_bet_amount_odd_over,"pb_even_under"=>$powerball_bet_amount_even_under,"pb_even_over"=>$powerball_bet_amount_even_over,
            // 'nb_odd_under'=>$normalball_bet_amount_odd_under,"nb_odd_over"=>$normalball_bet_amount_odd_over,"nb_even_under"=>$normalball_bet_amount_even_under,"nb_even_over"=>$normalball_bet_amount_even_over,
            // 'nb_odd_large'=>$normalball_bet_amount_odd_large,"nb_odd_medium"=>$normalball_bet_amount_odd_medium,"nb_odd_small"=>$normalball_bet_amount_odd_small,
            // 'nb_even_large'=>$normalball_bet_amount_even_large,"nb_even_medium"=>$normalball_bet_amount_even_medium,"nb_even_small"=>$normalball_bet_amount_even_small);

            // $result = DB::table('balancing_data')->where('type',$type)->first();

            // if($result == null){
            //     DB::table('balancing_data')->insert($balancing_data);
            // }else{
            //     DB::table('balancing_data')->where('type',$type)->delete();
            //     DB::table('balancing_data')->insert($balancing_data);
            // }

            if($type=="3min"){
                $type_id = "3";
            }
            if($type=="5min"){
                $type_id = "5";
            }


            $result = DB::select("SELECT '$type' AS 'type', SUM(pb_odd) AS pb_odd, SUM(pb_even) AS pb_even, SUM(pb_under) AS pb_under, SUM(pb_over) AS pb_over, SUM(nb_odd) AS nb_odd, SUM(nb_even) AS nb_even, SUM(nb_under) AS nb_under, SUM(nb_over) AS nb_over, SUM(nb_large) AS nb_large,SUM(nb_medium) AS nb_medium,SUM(nb_small) AS nb_small,SUM(pb_odd_under) AS pb_odd_under,SUM(pb_odd_over) AS pb_odd_over,SUM(pb_even_under) AS pb_even_under,SUM(pb_even_over) AS pb_even_over,SUM(nb_odd_under) AS nb_odd_under, SUM(nb_odd_over) AS nb_odd_over,SUM(nb_even_under) AS nb_even_under,SUM(nb_even_over) AS nb_even_over,SUM(nb_odd_large) AS nb_odd_large,SUM(nb_odd_medium) AS nb_odd_medium,SUM(nb_odd_small) AS nb_odd_small, SUM(nb_even_large) AS nb_even_large,SUM(nb_even_medium) AS nb_even_medium,SUM(nb_even_small) AS nb_even_small FROM balancing_data WHERE date = '$date' AND type = '$type' AND round = '$round'")[0];

            //$result = DB::table('balancing_data')->where('type',$type)->first();

            event(new BalancingDataWasReceived($result));

            if($balancing->balancing_type == "single"){

                $pb_o = $powerball_bet_amount_odd * $powerball_multiplier;
                $pb_e = $powerball_bet_amount_even * $powerball_multiplier;
                $pb_u = $powerball_bet_amount_under * $powerball_multiplier;
                $pb_ov = $powerball_bet_amount_over * $powerball_multiplier;

                $nb_o = $normalball_bet_amount_odd * $normalball_multiplier;
                $nb_e = $normalball_bet_amount_even * $normalball_multiplier;
                $nb_u = $normalball_bet_amount_under * $normalball_multiplier;
                $nb_ov = $normalball_bet_amount_over * $normalball_multiplier;

                $nb_l = $normalball_bet_amount_large * $normalball_sum_multiplier;
                $nb_m = $normalball_bet_amount_medium * $normalball_sum_multiplier;
                $nb_s = $normalball_bet_amount_small * $normalball_sum_multiplier;

                $pb_o >= $pb_e ? $pb_o == $pb_e ? $pb_oe_flag = 0 : $pb_oe_flag = 2 : $pb_oe_flag = 1;
                $pb_u >= $pb_ov ? $pb_u == $pb_ov ? $pb_uov_flag = 0 : $pb_uov_flag = 2 : $pb_uov_flag = 1;
                $nb_o >= $nb_e ? $nb_o == $nb_e ? $nb_oe_flag = 0 : $nb_oe_flag = 2 : $nb_oe_flag = 1;
                $nb_u >= $nb_ov ? $nb_u == $nb_ov ? $nb_uov_flag = 0 : $nb_uov_flag = 2 : $nb_uov_flag = 1;
                $nb_lms_flag = $nb_l >= $nb_m ? ($nb_l == $nb_m ? 4 : ($nb_m >= $nb_s ? ($nb_m == $nb_s ? 0 : 1) : 2)): 3;

                if ($nb_u + $nb_ov > $nb_l + $nb_m + $nb_s) {
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                    if ($nb_uov_flag == 1) {
                        $nb_m >= $nb_s ? $nb_m == $nb_s ? $nb_lms_flag = 0 : $nb_lms_flag = 2 : $nb_lms_flag = 1;
                    } elseif ($nb_uov_flag == 2) {
                        $nb_l >= $nb_m ? $nb_l == $nb_m ? $nb_lms_flag = 4 : $nb_lms_flag = 3 : $nb_lms_flag = 2;
                    }
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag,$small,$large,$medium);
                } else {
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag,$small,$large,$medium);
                    if ($nb_lms_flag === 3) {
                        $nb_uov_flag = 2;
                    } elseif ($nb_lms_flag === 1) {
                        $nb_uov_flag = 1;
                    }
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                }

                $pb_range = $this->pb_uov_function($pb_range, $pb_uov_flag,$pb_over,$pb_under);

                $normalball_sum_range_lable = [$nb_range[0],$nb_range[1]];

                if ($nb_oe_flag === 1) {
                    $normalball_odd_even = '!=';
                } elseif ($nb_oe_flag === 2) {
                    $normalball_odd_even = '=';
                }else{
                    $normalball_odd_even = $filter[array_rand($filter,1)];
                }

                $powerball_sum_range_lable = [$pb_range[0],$pb_range[1]];

                if ($pb_oe_flag === 1) {
                    $powerball_odd_even = '!=';
                } elseif ($pb_oe_flag === 2) {
                    $powerball_odd_even = '=';
                }else{
                    $powerball_odd_even = $filter[array_rand($filter,1)];
                }

            }

            if($balancing->balancing_type == "single_unbalance"){

                $pb_o = $powerball_bet_amount_odd * $powerball_multiplier;
                $pb_e = $powerball_bet_amount_even * $powerball_multiplier;
                $pb_u = $powerball_bet_amount_under * $powerball_multiplier;
                $pb_ov = $powerball_bet_amount_over * $powerball_multiplier;

                $nb_o = $normalball_bet_amount_odd * $normalball_multiplier;
                $nb_e = $normalball_bet_amount_even * $normalball_multiplier;
                $nb_u = $normalball_bet_amount_under * $normalball_multiplier;
                $nb_ov = $normalball_bet_amount_over * $normalball_multiplier;

                $nb_l = $normalball_bet_amount_large * $normalball_sum_multiplier;
                $nb_m = $normalball_bet_amount_medium * $normalball_sum_multiplier;
                $nb_s = $normalball_bet_amount_small * $normalball_sum_multiplier;

                $pb_o >= $pb_e ? $pb_o == $pb_e ? $pb_oe_flag = 0 : $pb_oe_flag = 2 : $pb_oe_flag = 1;
                $pb_u >= $pb_ov ? $pb_u == $pb_ov ? $pb_uov_flag = 0 : $pb_uov_flag = 2 : $pb_uov_flag = 1;
                $nb_o >= $nb_e ? $nb_o == $nb_e ? $nb_oe_flag = 0 : $nb_oe_flag = 2 : $nb_oe_flag = 1;
                $nb_u >= $nb_ov ? $nb_u == $nb_ov ? $nb_uov_flag = 0 : $nb_uov_flag = 2 : $nb_uov_flag = 1;
                $nb_lms_flag = $nb_l >= $nb_m ? ($nb_l == $nb_m ? 4 : ($nb_m >= $nb_s ? ($nb_m == $nb_s ? 0 : 1) : 2)): 3;

                if ($nb_u + $nb_ov > $nb_l + $nb_m + $nb_s) {
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                    if ($nb_uov_flag == 1) {
                        $nb_m >= $nb_s ? $nb_m == $nb_s ? $nb_lms_flag = 0 : $nb_lms_flag = 2 : $nb_lms_flag = 1;
                    } elseif ($nb_uov_flag == 2) {
                        $nb_l >= $nb_m ? $nb_l == $nb_m ? $nb_lms_flag = 4 : $nb_lms_flag = 3 : $nb_lms_flag = 2;
                    }
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag,$small,$large,$medium);
                } else {
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag,$small,$large,$medium);
                    if ($nb_lms_flag === 3) {
                        $nb_uov_flag = 2;
                    } elseif ($nb_lms_flag === 1) {
                        $nb_uov_flag = 1;
                    }
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                }

                $pb_range = $this->pb_uov_function($pb_range, $pb_uov_flag,$pb_over,$pb_under);

                $normalball_sum_range_lable = [$nb_range[0],$nb_range[1]];

                if ($nb_oe_flag === 1) {
                    $normalball_odd_even = '=';
                } elseif ($nb_oe_flag === 2) {
                    $normalball_odd_even = '!=';
                }else{
                    $normalball_odd_even = $filter[array_rand($filter,1)];
                }

                $powerball_sum_range_lable = [$pb_range[0],$pb_range[1]];

                if ($pb_oe_flag === 1) {
                    $powerball_odd_even = '=';
                } elseif ($pb_oe_flag === 2) {
                    $powerball_odd_even = '!=';
                }else{
                    $powerball_odd_even = $filter[array_rand($filter,1)];
                }

            }

            if($balancing->balancing_type == "combine"){

                $pb_ou = $powerball_bet_amount_odd*$powerball_combination_multiplier_odd_under;
                $pb_oov = $powerball_bet_amount_even*$powerball_combination_multiplier_odd_over;
                $pb_eu = $powerball_bet_amount_under*$powerball_combination_multiplier_even_under;
                $pb_eov = $powerball_bet_amount_over*$powerball_combination_multiplier_even_over;

                $nb_ou = $normalball_bet_amount_odd_under*$normalball_combination_multiplier;
                $nb_oov = $normalball_bet_amount_odd_over*$normalball_combination_multiplier;
                $nb_eu = $normalball_bet_amount_even_under*$normalball_combination_multiplier;
                $nb_eov = $normalball_bet_amount_even_over*$normalball_combination_multiplier;

                $nb_os = $normalball_bet_amount_odd_small*$normalball_combination_multiplier_odd_small;
                $nb_om = $normalball_bet_amount_odd_medium*$normalball_combination_multiplier_odd_medium;
                $nb_ol = $normalball_bet_amount_odd_large*$normalball_combination_multiplier_odd_large;
                $nb_es = $normalball_bet_amount_even_small*$normalball_combination_multiplier_even_small;
                $nb_em = $normalball_bet_amount_even_medium*$normalball_combination_multiplier_even_medium;
                $nb_el = $normalball_bet_amount_even_large*$normalball_combination_multiplier_even_large;

                $pb_o = $powerball_bet_amount_odd * $powerball_multiplier + ($pb_ou/2) + ($pb_oov/2);
                $pb_e = $powerball_bet_amount_even * $powerball_multiplier + ($pb_eu / 2) + ($pb_eu / 2);
                $pb_u = $powerball_bet_amount_under * $powerball_multiplier + ($pb_ou / 2) + ($pb_eu / 2);
                $pb_ov = $powerball_bet_amount_over * $powerball_multiplier + ($pb_eu / 2) + ($pb_oov /2);

                $nb_o = $normalball_bet_amount_odd * $normalball_multiplier + ($nb_ou/2) + ($nb_oov/2) + ($nb_os/2) + ($nb_om/2) + ($nb_ol/2);
                $nb_e = $normalball_bet_amount_even * $normalball_multiplier + ($nb_eu/2) + ($nb_eov/2) + ($nb_es/2) + ($nb_em/2) + ($nb_el/2);
                $nb_u = $normalball_bet_amount_under * $normalball_multiplier + ($nb_eu/2) + ($nb_ou/2);
                $nb_ov = $normalball_bet_amount_over * $normalball_multiplier + ($nb_oov/2) + ($nb_eov/2);

                $nb_l = $normalball_bet_amount_large * $normalball_sum_multiplier + ($nb_ol/2) + ($nb_el/2);
                $nb_m = $normalball_bet_amount_medium * $normalball_sum_multiplier + ($nb_om/2) + ($nb_em/2);
                $nb_s = $normalball_bet_amount_small * $normalball_sum_multiplier + ($nb_os/2) + ($nb_es/2);

                $pb_o >= $pb_e ? $pb_o == $pb_e ? $pb_oe_flag = 0 : $pb_oe_flag = 2 : $pb_oe_flag = 1;
                $pb_u >= $pb_ov ? $pb_u == $pb_ov ? $pb_uov_flag = 0 : $pb_uov_flag = 2 : $pb_uov_flag = 1;
                $nb_o >= $nb_e ? $nb_o == $nb_e ? $nb_oe_flag = 0 : $nb_oe_flag = 2 : $nb_oe_flag = 1;
                $nb_u >= $nb_ov ? $nb_u == $nb_ov ? $nb_uov_flag = 0 : $nb_uov_flag = 2 : $nb_uov_flag = 1;
                if ($nb_l >= $nb_m) {
                    if ($nb_l == $nb_m) {
                        $nb_lms_flag = 4;
                    } else {
                        $nb_lms_flag = ($nb_m >= $nb_s) ? ($nb_m == $nb_s) ? 0 : 1 : 2;
                    }
                } else {
                    $nb_lms_flag = 3;
                }

                if ($nb_u + $nb_ov > $nb_l + $nb_m + $nb_s){
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                    // under -> medium small
                    if ($nb_uov_flag == 1) {
                        $nb_m >= $nb_s ? $nb_m == $nb_s ? $nb_lms_flag = 0 : $nb_lms_flag = 2 : $nb_lms_flag = 1;
                    } else if ($nb_uov_flag == 2) { // over -> medium large
                        $nb_l >= $nb_m ? $nb_l == $nb_m ? $nb_lms_flag = 4 : $nb_lms_flag = 3 : $nb_lms_flag = 2;
                    }
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag, $small,$large,$medium);
                } else {
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag, $small,$large,$medium);
                    if ($nb_lms_flag == 3) { //large -> over
                        $nb_uov_flag = 2;
                    } else if ($nb_lms_flag == 1) { // small -> under
                        $nb_uov_flag = 1;
                    }
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                }

                $pb_range = $this->pb_uov_function($pb_range, $pb_uov_flag,$pb_over,$pb_under);

                $normalball_sum_range_lable = [$nb_range[0],$nb_range[1]];

                //$message = "Normal ball sum must be determined within that range : " . $nb_range[0] . "~" . $nb_range[1] . ", ";

                if($nb_oe_flag == 1) {
                    $normalball_odd_even = '!=';
                    //$message .= "Normal ball Must be Odd ";
                }elseif($nb_oe_flag == 2) {
                    $normalball_odd_even = '=';
                    //$message .= "Normal ball Must be Even";
                }else{
                    $normalball_odd_even = $filter[array_rand($filter,1)];
                }

                $powerball_sum_range_lable = [$pb_range[0],$pb_range[1]];

                //$message .= "<br/> powerball ball sum must be determined within that range : " . $pb_range[0] . "~" . $pb_range[1] . ", ";

                if($pb_oe_flag == 1) {
                    //$message .= "Power ball Must be Odd ";
                    $powerball_odd_even = '!=';
                }elseif ($pb_oe_flag == 2) {
                    $powerball_odd_even = '=';
                    //$message .= "Power ball Must be Even";
                }else{
                    $powerball_odd_even = $filter[array_rand($filter,1)];
                }

            }

            if($balancing->balancing_type == "combine_unbalance"){

                $pb_ou = $powerball_bet_amount_odd_under*$powerball_combination_multiplier_odd_under;
                $pb_oov = $powerball_bet_amount_odd_over*$powerball_combination_multiplier_odd_over;
                $pb_eu = $powerball_bet_amount_even_under*$powerball_combination_multiplier_even_under;
                $pb_eov = $powerball_bet_amount_even_over*$powerball_combination_multiplier_even_over;

                $nb_ou = $normalball_bet_amount_odd_under*$normalball_combination_multiplier;
                $nb_oov = $normalball_bet_amount_odd_over*$normalball_combination_multiplier;
                $nb_eu = $normalball_bet_amount_even_under*$normalball_combination_multiplier;
                $nb_eov = $normalball_bet_amount_even_over*$normalball_combination_multiplier;

                $nb_os = $normalball_bet_amount_odd_small*$normalball_combination_multiplier_odd_small;
                $nb_om = $normalball_bet_amount_even_medium*$normalball_combination_multiplier_odd_medium;
                $nb_ol = $normalball_bet_amount_odd_large*$normalball_combination_multiplier_odd_large;
                $nb_es = $normalball_bet_amount_even_small*$normalball_combination_multiplier_even_small;
                $nb_em = $normalball_bet_amount_even_medium*$normalball_combination_multiplier_even_medium;
                $nb_el = $normalball_bet_amount_even_large*$normalball_combination_multiplier_even_large;

                $pb_o = $powerball_bet_amount_odd * $powerball_multiplier + ($pb_ou/2) + ($pb_oov/2);
                $pb_e = $powerball_bet_amount_even * $powerball_multiplier + ($pb_eu / 2) + ($pb_eu / 2);
                $pb_u = $powerball_bet_amount_under * $powerball_multiplier + ($pb_ou / 2) + ($pb_eu / 2);
                $pb_ov = $powerball_bet_amount_over * $powerball_multiplier + ($pb_eu / 2) + ($pb_oov /2);

                $nb_o = $normalball_bet_amount_odd * $normalball_multiplier + ($nb_ou/2) + ($nb_oov/2) + ($nb_os/2) + ($nb_om/2) + ($nb_ol/2);
                $nb_e = $normalball_bet_amount_even * $normalball_multiplier + ($nb_eu/2) + ($nb_eov/2) + ($nb_es/2) + ($nb_em/2) + ($nb_el/2);
                $nb_u = $normalball_bet_amount_under * $normalball_multiplier + ($nb_eu/2) + ($nb_ou/2);
                $nb_ov = $normalball_bet_amount_over * $normalball_multiplier + ($nb_oov/2) + ($nb_eov/2);

                $nb_l = $normalball_bet_amount_large * $normalball_sum_multiplier + ($nb_ol/2) + ($nb_el/2);
                $nb_m = $normalball_bet_amount_medium * $normalball_sum_multiplier + ($nb_om/2) + ($nb_em/2);
                $nb_s = $normalball_bet_amount_small * $normalball_sum_multiplier + ($nb_os/2) + ($nb_es/2);

                $pb_o >= $pb_e ? $pb_o == $pb_e ? $pb_oe_flag = 0 : $pb_oe_flag = 2 : $pb_oe_flag = 1;
                $pb_u >= $pb_ov ? $pb_u == $pb_ov ? $pb_uov_flag = 0 : $pb_uov_flag = 2 : $pb_uov_flag = 1;
                $nb_o >= $nb_e ? $nb_o == $nb_e ? $nb_oe_flag = 0 : $nb_oe_flag = 2 : $nb_oe_flag = 1;
                $nb_u >= $nb_ov ? $nb_u == $nb_ov ? $nb_uov_flag = 0 : $nb_uov_flag = 2 : $nb_uov_flag = 1;
                if ($nb_l >= $nb_m) {
                    if ($nb_l == $nb_m) {
                        $nb_lms_flag = 4;
                    } else {
                        $nb_lms_flag = ($nb_m >= $nb_s) ? ($nb_m == $nb_s) ? 0 : 1 : 2;
                    }
                } else {
                    $nb_lms_flag = 3;
                }

                if ($nb_u + $nb_ov > $nb_l + $nb_m + $nb_s){
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                    // under -> medium small
                    if ($nb_uov_flag == 1) {
                        $nb_m >= $nb_s ? $nb_m == $nb_s ? $nb_lms_flag = 0 : $nb_lms_flag = 2 : $nb_lms_flag = 1;
                    } else if ($nb_uov_flag == 2) { // over -> medium large
                        $nb_l >= $nb_m ? $nb_l == $nb_m ? $nb_lms_flag = 4 : $nb_lms_flag = 3 : $nb_lms_flag = 2;
                    }
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag, $small,$large,$medium);
                } else {
                    $nb_range = $this->nb_lms_function($nb_range, $nb_lms_flag, $small,$large,$medium);
                    if ($nb_lms_flag == 3) { //large -> over
                        $nb_uov_flag = 2;
                    } else if ($nb_lms_flag == 1) { // small -> under
                        $nb_uov_flag = 1;
                    }
                    $nb_range = $this->nb_uov_function($nb_range, $nb_uov_flag,$over,$under);
                }

                $pb_range = $this->pb_uov_function($pb_range, $pb_uov_flag,$pb_over,$pb_under);

                $normalball_sum_range_lable = [$nb_range[0],$nb_range[1]];

                //$message = "Normal ball sum must be determined within that range : " . $nb_range[0] . "~" . $nb_range[1] . ", ";

                if($nb_oe_flag == 1) {
                    $normalball_odd_even = '=';
                    //$message .= "Normal ball Must be Odd ";
                }elseif($nb_oe_flag == 2) {
                    $normalball_odd_even = '!=';
                    //$message .= "Normal ball Must be Even";
                }else{
                    $normalball_odd_even = $filter[array_rand($filter,1)];
                }

                $powerball_sum_range_lable = [$pb_range[0],$pb_range[1]];

                //$message .= "<br/> powerball ball sum must be determined within that range : " . $pb_range[0] . "~" . $pb_range[1] . ", ";

                if($pb_oe_flag == 1) {
                    //$message .= "Power ball Must be Odd ";
                    $powerball_odd_even = '=';
                }elseif ($pb_oe_flag == 2) {
                    $powerball_odd_even = '!=';
                    //$message .= "Power ball Must be Even";
                }else{
                    $powerball_odd_even = $filter[array_rand($filter,1)];
                }

            }

            $selectedVideoFilePath = array();

                for ($i=0; $i < count($playlistTrackIdsArray); $i++) {

                    if($type == "3min"){
                        $newTrackVideo = ThreeMinVideoList::whereRaw("(normalball % 2) $normalball_odd_even 0")->whereRaw("(powerball % 2) $powerball_odd_even 0")->whereBetween('normalball', $normalball_sum_range_lable)->whereBetween('powerball', $powerball_sum_range_lable)->inRandomOrder()->first();
                    }

                    if($type == "5min"){
                        $newTrackVideo = FiveMinVideoList::whereRaw("(normalball % 2) $normalball_odd_even 0")->whereRaw("(powerball % 2) $powerball_odd_even 0")->whereBetween('normalball', $normalball_sum_range_lable)->whereBetween('powerball', $powerball_sum_range_lable)->inRandomOrder()->first();
                    }

                    if(is_null($newTrackVideo) ){
                        return response()->json(['response' => 'fail']);
                    }

                    $newTrackVideo->count = $newTrackVideo->count+1;
                    $newTrackVideo->save();

                    array_push($selectedVideoFilePath,$newTrackVideo->file_path);

                    $currentTrackID=$playlistTrackIdsArray[$i];
                    $newVideoID=$selectedVideoFilePath[$i];

                    $playlistTrack = PlaylistTrack::where('playlist_id',$playlistID)->where('track_id',$playlistTrackIdsArray[$i])->first();

                    if(is_null($playlistTrack) ){
                        //return response()->json(['response' => 'fail','msg' => 'No matching playlist']);
                        return response()->json(['response' => 'fail']);
                    }

                    $playlistTrack->video_id =  $newTrackVideo->id;
                    $playlistTrack->save();
                }

                $selectedVideoFilePath = json_encode($selectedVideoFilePath);

                $sourcePath = $this->sourcePath;
                $tempPath = $this->tempPath;
                $destinationPath = $this->destinationPath.$type.'/' . $playlistID . '/';

                $PythonScriptRunnerService = new PythonScriptRunnerService();
                $PythonScriptRunnerService->replaceTrack($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID);

                //return response()->json(['response' => 'success','msg' => "Playlist Tracks changed. Balancing Type : ".$balancing->balancing_type]);
                return response()->json(['response' => 'success']);

        }catch(\Exception $error){
            //dd($error);
            //return response()->json(['response' => 'fail','msg' => 'Something wrong!']);
            return response()->json(['response' => 'fail']);
        }

    }

    public function nb_lms_function($nb_range,$nb_lms_flag,$small,$large,$medium){
        if ($nb_lms_flag == 4) {
            $nb_range[0] = $nb_range[0] > $medium[0] ? $nb_range[0] : $medium[0];
            $nb_range[1] = $nb_range[1] > $large[1] ? $large[1] : $nb_range[1];
        } else if ($nb_lms_flag == 3) {
            $nb_range[0] = $nb_range[0] > $large[0] ? $nb_range[0] : $large[0];
            $nb_range[1] = $nb_range[0] > $large[1] ? $large[1] : $nb_range[1];
        } else if ($nb_lms_flag == 2) {
            $nb_range[0] = $nb_range[0] > $medium[0] ? $nb_range[0] : $medium[0];
            $nb_range[1] = $nb_range[1] > $medium[1] ? $medium[1] : $nb_range[1];
        } else if ($nb_lms_flag == 1) {
            $nb_range[0] = $nb_range[0] > $small[0] ? $nb_range[0] : $small[0];
            $nb_range[1] = $nb_range[1] > $small[1] ? $small[1] : $nb_range[1];
        } else {
            $nb_range[0] = $nb_range[0] > $small[0] ? $nb_range[0] : $small[0];
            $nb_range[1] = $nb_range[1] > $medium[1] ? $medium[1] : $nb_range[1];
        }

        return $nb_range;
    }

    public function nb_uov_function($nb_range, $nb_uov_flag,$over,$under) {
        if ($nb_uov_flag === 0) {
            return $nb_range;
        } elseif ($nb_uov_flag === 2) {
            $nb_range[0] = $nb_range[0] > $over[0] ? $nb_range[0] : $over[0];
            $nb_range[1] = $nb_range[1] > $over[1] ? $over[1] : $nb_range[1];
        } else {
            $nb_range[0] = $nb_range[0] > $under[0] ? $nb_range[0] : $under[0];
            $nb_range[1] = $nb_range[1] > $under[1] ? $under[1] : $nb_range[1];
        }
        return $nb_range;
    }

    public function pb_uov_function($pb_range, $pb_uov_flag,$pb_over,$pb_under) {
        if ($pb_uov_flag === 0) {
            return $pb_range;
        } elseif ($pb_uov_flag === 2) {
            $pb_range[0] = $pb_range[0] > $pb_over[0] ? $pb_range[0] : $pb_over[0];
            $pb_range[1] = $pb_range[1] > $pb_over[1] ? $pb_over[1] : $pb_range[1];
        } else {
            $pb_range[0] = $pb_range[0] > $pb_under[0] ? $pb_range[0] : $pb_under[0];
            $pb_range[1] = $pb_range[1] > $pb_under[1] ? $pb_under[1] : $pb_range[1];
        }
        return $pb_range;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Balancing  $balancing
     * @return \Illuminate\Http\Response
     */
    public function show(Balancing $balancing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Balancing  $balancing
     * @return \Illuminate\Http\Response
     */
    public function edit(Balancing $balancing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Balancing  $balancing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$balance,$type)
    {

        DB::table('balancings')->where('stream_type',$type)->where('status',1)->update(['status' => 0]);

        DB::table('balancings')->where('balancing_type',$balance)->where('stream_type',$type)->update(['status' => 1]);

        $request->session()->flash('success','Balancing type changed successfully.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Balancing  $balancing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Balancing $balancing)
    {
        //
    }
}
