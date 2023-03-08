<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VideoList;
use App\FiveMinVideoList;
use App\ThreeMinVideoList;
use App\Playlist;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Service\CommandService\PythonScriptRunnerService;

class VideoListController extends Controller
{
    private $sourcePath;

    public function __construct()
    {
        $this->middleware('auth');
        $this->sourcePath = env('SOURCE_PATH');
        $this->videolistHost = env('VIDEOLIST_HOST');
    }

    public function index($type)
    {
        if($type == "3min"){
            $videoList=DB::table('three_min_video_lists')->where('type',$type)->orderBy('id', 'ASC')->paginate(100);
        }
        if($type == "5min"){
            $videoList=DB::table('five_min_video_lists')->where('type',$type)->orderBy('id', 'ASC')->paginate(100);
        }

        return view('dashboard.video_list')->with('videoList',$videoList)->with('type',$type);
    }

    public function videoListUpdateCommand(Request $request)
    {
        $subfolderPath=$request->get('type');
        $status=$request->get('status');

        $process = new Process(['python3', 'scripts/videolist_update.py',$this->sourcePath,$subfolderPath,$this->videolistHost,$status]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
            $request->session()->flash('delete', 'Something goes wrong. Please try again');
            return back();

        }else{
            $request->session()->flash('success','Videolist Sync Successful.');
            return back();

        }
    }

    public function delete(Request $request,$video_id,$type){

        $PythonScriptRunnerService = new PythonScriptRunnerService();

        try{
            if($type=="3min"){
                $response = ThreeMinVideoList::find($video_id);
                $PythonScriptRunnerService->deleteFile($response->file_path);
                $response->delete();
            }

            if($type=="5min"){
                $response = FiveMinVideoList::find($video_id);
                $PythonScriptRunnerService->deleteFile($response->file_path);
                $response->delete();
            }

            $request->session()->flash('delete','Video File deleted.');
            return back();
        }catch(\Exception $error){
            $request->session()->flash('Something goes wrong. Please try again');
            return back();
        }
    }

    public function listThreeMinVideos()
    {
        $threeMinList=DB::table('video_lists')->where('type','3min')->orderBy('id', 'ASC')->get();
        dd($threeMinList);

        return view('dashboard.videotype3')->with('threeMinList',$threeMinList);
    }

    public function listFiveMinVideos()
    {
        $fiveMinList=DB::table('video_lists')->where('type','5min')->orderBy('id', 'ASC')->get();
        return view('dashboard.videotype5')->with('fiveMinList',$fiveMinList);
    }
    public function video_playlist_3min()
    {
        $playlists=Playlist::where('type','3 Min')->get();
        //dd( $playlists);
        return view('dashboard.videoplaylist_3min',compact('playlists'));
    }
    public function video_playlist_5min()
    {
        $playlists=Playlist::where('type','5 Min')->get();
        //dd( $playlists);
        return view('dashboard.videoplaylist_5min',compact('playlists'));
    }


}