<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use App\PlaylistTrack;
use App\ThreeMinVideoList;
use App\FiveMinVideoList;
use App\Playlist;
use App\Service\CommandService\PythonScriptRunnerService;
use App\Jobs\CreatePlaylistTrack;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;
use Carbon\Carbon;

class PlaylistTrackController extends Controller
{
    private $sourcePath;
    private $tempPath;
    private $destinationPath;
    private $waitingVideoThree;
    private $waitingVideoFive;
    private $watingVideoFileThree;
    private $watingVideoFileFive;
    private $watingVideoSourceThree;
    private $watingVideoSourceFive;

    public function __construct()
    {
        $this->middleware('auth');
        $this->sourcePath = env('SOURCE_PATH');
        $this->tempPath = env('TEMP_PATH');
        $this->destinationPath = env('DESTINATION_PATH');
        $this->waitingVideoThree = env('WAITING_VIDEO_THREE_MIN');
        $this->waitingVideoFive = env('WAITING_VIDEO_FIVE_MIN');
        $this->watingVideoFileThree = env('WAITING_VIDEO_FILE_THREE');
        $this->watingVideoFileFive = env('WAITING_VIDEO_FILE_FIVE');
        $this->watingVideoSourceThree = env('WAITING_VIDEO_SOURCE_THREE');
        $this->watingVideoSourceFive = env('WAITING_VIDEO_SOURCE_FIVE');
    }

    public function index($playlistID)
    {
        $playlist = Playlist::find($playlistID);

        if($playlist->type == "3min"){
            $playlistTracks=DB::table('three_min_video_lists')
            ->select('*')
            ->join('playlist_tracks', 'playlist_tracks.video_id', '=', 'three_min_video_lists.id')
            ->where('playlist_id',$playlistID)->get();
            // dd($playlistTracks);


        }


        if($playlist->type == "5min"){
            $playlistTracks=DB::table('five_min_video_lists')
            ->select('*')
            ->join('playlist_tracks', 'playlist_tracks.video_id', '=', 'five_min_video_lists.id')
            ->where('playlist_id',$playlistID)->get();
        }

        return view('dashboard.playlist_track')->with('playlistTracks',$playlistTracks)->with('playlistID',$playlistID)->with('type',$playlist->type);
    }

    public function regeneratePlaylistTracks(Request $request)
    {
        try{

            $playlistID=$request->get('playlist_id');
            $type=$request->get('type');

            $sourcePath = $this->sourcePath;
            $tempPath = $this->tempPath;
            $destinationPath = $this->destinationPath.$type.'/'.$playlistID."/";

            $selectedVideoFilePath = array();
            $playlistTrackIds = array();

            $playlist = Playlist::find($playlistID);

            if($type == "3min"){
                $videoListCount = ThreeMinVideoList::where('type',$type)->count();
                $wating_video_url = $this->waitingVideoThree;
                $wating_video_filename = $this->watingVideoFileThree;
                $sourceFilePath = $this->watingVideoSourceThree.$wating_video_filename;
            }

            if($type == "5min"){
                $videoListCount = FiveMinVideoList::where('type',$type)->count();
                $wating_video_url = $this->waitingVideoFive;
                $wating_video_filename = $this->watingVideoFileFive;
                $sourceFilePath = $this->watingVideoSourceFive.$wating_video_filename;
            }

            $length = $playlist->size+$playlist->size;

            $trackCount = PlaylistTrack::where('playlist_id',$playlistID)->count();

            if($trackCount == $playlist->size){

                $PythonScriptRunnerService = new PythonScriptRunnerService();
                //$PythonScriptRunnerService->deleteFile($playlist->file_path);
                $fileCount = $playlist->size+$playlist->size;
                $type = $playlist->type;

                $trackPath = $this->destinationPath . $type .'/'.$playlist->id;
                $PythonScriptRunnerService->deleteFolder($trackPath);

                PlaylistTrack::where('playlist_id', $playlist->id)->delete();

                $destinationFilePath = $this->destinationPath.$type."/".$playlistID."/";

                $PythonScriptRunnerService->copyFile($sourceFilePath,$destinationFilePath.$playlistID."_".$wating_video_filename,$destinationFilePath);

            }
                if($type == "3min"){

                    $videoList = DB::table('three_min_video_lists')
                        ->where('type', $type)
                        // ->where('updated_at', '<', Carbon::now()->subDays(env('PAST_DAYS')))
                        ->orderBy('count')
                        ->take($length/2)
                        ->get()
                        ->toArray();

                    shuffle($videoList);

                    $flag=0;
                    for ($i=2; $i < $length+1; $i+=2) {

                        if(isset($videoList[$flag]->id)){

                            $res = new PlaylistTrack([
                            'playlist_id' => $playlistID,
                            'track_id' => $i,
                            'video_id' => $videoList[$flag]->id,
                            'status' => 1,
                            ]);

                            array_push($playlistTrackIds,$i);

                            $res->save();
                            $video = ThreeMinVideoList::find($videoList[$flag]->id);
                            $video->count = $video->count+1;
                            $video->save();
                            array_push($selectedVideoFilePath,$video->file_path);
                            $flag++;
                        }
                    }
                }

                if($type == "5min"){

                    $videoList = DB::table('five_min_video_lists')
                        ->where('type', $type)
                        ->where('updated_at', '<', Carbon::now()->subDays(env('PAST_DAYS')))
                        ->orderBy('count')
                        ->take($length/2)
                        ->get()
                        ->toArray();

                    shuffle($videoList);

                    $flag=0;
                    for ($i=2; $i < $length+1; $i+=2) {

                        if(isset($videoList[$flag]->id)){

                            $res = new PlaylistTrack([
                            'playlist_id' => $playlistID,
                            'track_id' => $i,
                            'video_id' => $videoList[$flag]->id,
                            'status' => 1,
                            ]);

                            array_push($playlistTrackIds,$i);

                            $res->save();
                            $video = FiveMinVideoList::find($videoList[$flag]->id);
                            $video->count = $video->count+1;
                            $video->save();
                            array_push($selectedVideoFilePath,$video->file_path);
                            $flag++;
                        }
                    }
                }

            $playlistTrackIds = json_encode($playlistTrackIds);

            $selectedVideoFilePath = json_encode($selectedVideoFilePath);


            CreatePlaylistTrack::dispatch($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID);

            $request->session()->flash('success','Playlist Tracks created.');
            return back();

        }catch(\Exception $error){
            dd($error);
            $request->session()->flash('delete', 'Something goes wrong. Please try again');
            return back();
        }

    }

    public function generateRandomVideoTracks(Request $request)
    {

        try{

            $playlistID=$request->get('playlist_id');
            $type=$request->get('type');

            $sourcePath = $this->sourcePath;
            $tempPath = $this->tempPath;
            $destinationPath = $this->destinationPath.$type.'/'.$playlistID."/";

            $selectedVideoFilePath = array();
            $playlistTrackIds = array();

            $playlist = Playlist::find($playlistID);

            if($type == "3min"){
                $videoListCount = ThreeMinVideoList::where('type',$type)->count();
            }

            if($type == "5min"){
                $videoListCount = FiveMinVideoList::where('type',$type)->count();
            }

            $length = $playlist->size+$playlist->size;

            // if($playlist->size > $videoListCount){
            //     $request->session()->flash('delete','No suffiecient video files');
            //     return back();
            // }

            $trackCount = PlaylistTrack::where('playlist_id',$playlistID)->count();

            if($trackCount == $playlist->size){
                $request->session()->flash('delete','No space of playlist');
                return back();
            }

            for ($i=2; $i < $length+1; $i+=2) {

                if($type == "3min"){

                    $videoList = DB::table('three_min_video_lists')->where('type',$type)->get()->random(1);

                    $res = new PlaylistTrack([
                        'playlist_id' => $playlistID,
                        'track_id' => $i,
                        'video_id' => $videoList[0]->id,
                        'status' => 1,
                        ]);

                    array_push($playlistTrackIds,$i);

                    $res->save();
                    $videoList = ThreeMinVideoList::find($videoList[0]->id);
                    $videoList->count = $videoList->count+1;
                    $videoList->save();
                    array_push($selectedVideoFilePath,$videoList->file_path);
                }

                if($type == "5min"){

                    $videoList = DB::table('five_min_video_lists')->where('type',$type)->get()->random(1);

                    $res = new PlaylistTrack([
                        'playlist_id' => $playlistID,
                        'track_id' => $i,
                        'video_id' => $videoList[0]->id,
                        'status' => 1,
                        ]);

                    array_push($playlistTrackIds,$i);

                    $res->save();
                    $videoList = FiveMinVideoList::find($videoList[0]->id);
                    $videoList->count = $videoList->count+1;
                    $videoList->save();
                    array_push($selectedVideoFilePath,$videoList->file_path);
                }

            }

            $playlistTrackIds = json_encode($playlistTrackIds);

            $selectedVideoFilePath = json_encode($selectedVideoFilePath);


            CreatePlaylistTrack::dispatch($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID);

            // $PythonScriptRunnerService = new PythonScriptRunnerService();

            // $PythonScriptRunnerService->replaceTrack($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID);

            // $process = new Process(['python3', 'scripts/playlist_generator.py', $selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath]);
            // $process->run();

            // if (!$process->isSuccessful()) {
            //     throw new ProcessFailedException($process);
            // }else{
            //     dd($process->getOutput());
            // }


            $request->session()->flash('success','Playlist Tracks created.');
            return back();

        }catch(\Exception $error){
            dd($error);
            $request->session()->flash('delete', 'Something goes wrong. Please try again');
            return back();
        }

    }

    public function replaceVideoTrack(Request $request)
    {

        try{

            $playlistID=$request->get('playlist_id');
            $type=$request->get('type');
            $playlistTrackIdsArray = explode(",",$request->get('current_track_id'));
            $playlistTrackIds = json_encode($playlistTrackIdsArray);

            $newTrackVideoIds = explode(",",$request->get('new_track_video_id'));

            $selectedVideoFilePath = array();

            for ($i=0; $i < count($newTrackVideoIds); $i++) {
                if($type == "3min"){
                    $newTrackVideo = ThreeMinVideoList::find($newTrackVideoIds[$i]);
                }
                if($type == "5min"){
                    $newTrackVideo = FiveMinVideoList::find($newTrackVideoIds[$i]);
                }

                $newTrackVideo->count = $newTrackVideo->count+1;
                $newTrackVideo->save();

                array_push($selectedVideoFilePath,$newTrackVideo->file_path);

                $playlistID=$request->get('playlist_id');
                $currentTrackID=$playlistTrackIdsArray[$i];
                $newVideoID=$selectedVideoFilePath[$i];

                $playlistTrack = PlaylistTrack::find($currentTrackID);

                $playlistTrack = PlaylistTrack::where('playlist_id',$playlistID)->where('track_id',$playlistTrackIdsArray[$i])->first();

                $playlistTrack->video_id =  $newTrackVideoIds[$i];
                $playlistTrack->save();
            }

            $selectedVideoFilePath = json_encode($selectedVideoFilePath);

            $sourcePath = $this->sourcePath;
            $tempPath = $this->tempPath;
            $destinationPath = $this->destinationPath.$type.'/'.$playlistID.'/';

            // $process = new Process(['python3', 'scripts/replace_track.py',$selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath]);
            // $process->run();
            //dd($newTrackVideoIdsPass);
            $PythonScriptRunnerService = new PythonScriptRunnerService();
            $PythonScriptRunnerService->replaceTrack($selectedVideoFilePath,$playlistTrackIds,$sourcePath,$tempPath,$destinationPath,$playlistID);

            // if (!$process->isSuccessful()) {
            //     //return response()->json(['error' => 'invalid'], 401);
            //     throw new ProcessFailedException($process);
            // }else{
            //     $data = $process->getOutput();
            //     dd($data);
            //     return response()->json(['success' => 'success'], 200);
            // }

            $request->session()->flash('success','Playlist Tracks changed.');
            return back();

        }catch(\Exception $error){
            $request->session()->flash('delete', 'Something goes wrong. Please try again');
            return back();
        }

    }

    public function replaceVideoTrackByFilter(Request $request)
    {
        try{

            $playlistTrackIdsArray = explode(",",$request->get('current_track_id'));
            $playlistTrackIds = json_encode($playlistTrackIdsArray);

            $playlistID=$request->get('playlist_id');
            $type=$request->get('type');

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
                        ->whereRaw("(powerball % 2) $powerball_odd_even 0")->where('powerball', $powerball_under_over , 4)->inRandomOrder()->first();

                    }
                    if($type == "5min"){
                        $newTrackVideo = FiveMinVideoList::whereRaw("(normalball % 2) $normalball_odd_even 0")->where('normalball', $normalball_under_over , 72)
                        ->whereRaw("(powerball % 2) $powerball_odd_even 0")->where('powerball', $powerball_under_over , 4)->inRandomOrder()->first();
                    }


                    if(is_null($newTrackVideo) ){
                        $request->session()->flash('delete', 'No matching videos');
                        return back();
                    }

                    $newTrackVideo->count = $newTrackVideo->count+1;
                    $newTrackVideo->save();

                    array_push($selectedVideoFilePath,$newTrackVideo->file_path);

                    $playlistID=$request->get('playlist_id');
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
                $request->session()->flash('success','Playlist Tracks changed.');
                return back();

        }catch(\Exception $error){
            $request->session()->flash('delete', 'Something goes wrong. Please try again');
            return back();
        }

    }

}
