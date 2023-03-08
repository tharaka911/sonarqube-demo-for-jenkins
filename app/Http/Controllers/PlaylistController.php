<?php

namespace App\Http\Controllers;

use App\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Service\CommandService\PythonScriptRunnerService;
use App\PlaylistTrack;

class PlaylistController extends Controller
{
    private $host;
    private $playlistSavePath;
    private $playlistFetchURL;
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
        $this->host = env('PLAYLIST_HOST');
        $this->playlistSavePath = env('PLAYLIST_SAVE_PATH');
        $this->playlistFetchURL = env('PLAYLIST_FETCH_URL');
        $this->destinationPath = env('DESTINATION_PATH');
        $this->waitingVideoThree = env('WAITING_VIDEO_THREE_MIN');
        $this->waitingVideoFive = env('WAITING_VIDEO_FIVE_MIN');
        $this->watingVideoFileThree = env('WAITING_VIDEO_FILE_THREE');
        $this->watingVideoFileFive = env('WAITING_VIDEO_FILE_FIVE');
        $this->watingVideoSourceThree = env('WAITING_VIDEO_SOURCE_THREE');
        $this->watingVideoSourceFive = env('WAITING_VIDEO_SOURCE_FIVE');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $playlists=Playlist::where('type',$type)->get();
        return view('dashboard.video_playlist',compact('playlists'))->with('type',$type);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->get('type');

        if($type == "3min"){
            $wating_video_url = $this->waitingVideoThree;
            $wating_video_filename = $this->watingVideoFileThree;
            $sourceFilePath = $this->watingVideoSourceThree.$wating_video_filename;

            #$destinationFilePath = sys.argv[2]
        }

        if($type == "5min"){
            $wating_video_url = $this->waitingVideoFive;
            $wating_video_filename = $this->watingVideoFileFive;
            $sourceFilePath = $this->watingVideoSourceFive.$wating_video_filename;
        }
;
        try{
            $res = new Playlist([
                'name' => $request->get('name'),
                'url' => null,
                'type' => $type,
                'count' => $request->get('count'),
                'size' => $request->get('size'),
                'waiting_video_url' => null,
                'status' => $request->get('status'),
                ]);

            $res->save();

            $id = $res->id;
            $playlist = Playlist::find($id);

            $url = $this->playlistSavePath."/".$type. "/".$type."_".$res->id.".xspf";
            $accessUrl = $this->playlistFetchURL."/".$type. "/".$type."_".$res->id.".xspf";

            $playlist->url = $accessUrl;
            $playlist->file_path = $url;
            $playlist->waiting_video_url = $wating_video_url.$id."_".$wating_video_filename;
            $playlist->save();

            $baseUrl = $this->host ."/".$type."/".$id."/";

            $PythonScriptRunnerService = new PythonScriptRunnerService();
            $PythonScriptRunnerService->generatePlaylist($baseUrl, $url, $request->get('size')+$request->get('size'),$baseUrl.$id."_".$wating_video_filename,$id);

            $destinationFilePath = $this->destinationPath.$type."/".$id."/";

            $PythonScriptRunnerService->copyFile($sourceFilePath,$destinationFilePath.$id."_".$wating_video_filename,$destinationFilePath);

            $request->session()->flash('success','Playlist created.');
            return back();
        }catch(\Exception $error){
            $request->session()->flash('Something goes wrong. Please try again');
            return back();
        }
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
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    public function delete(Request $request,$id)
    {

        try{
            $response = Playlist::find($id);

            $PythonScriptRunnerService = new PythonScriptRunnerService();
            $PythonScriptRunnerService->deleteFile($response->file_path);
            $fileCount = $response->size+$response->size;
            $type = $response->type;

            $trackPath = $this->destinationPath . $type .'/'.$response->id;
            // for ($i=2; $i <= $fileCount; $i+=2) {
            //     $PythonScriptRunnerService->deleteFile($trackPath.$i.".mp4");
            // }
            $PythonScriptRunnerService->deleteFolder($trackPath);

            $response->delete();
            PlaylistTrack::where('playlist_id', $response->id)->delete();
            $request->session()->flash('delete','Playlist deleted.');
            return back();
        }catch(\Exception $error){
            $request->session()->flash('Something goes wrong. Please try again');
            return back();
        }
    }

    // public function find(Request $request)
    // {
    //     $query = Playlist::select('*');

    //     if ($request->input('q')) {
    //         $query->where('name', 'like', "%{$request->input('name')}%");
    //     }

    //     $results = $query->orderBy('created_at', 'desc')->get();

    //     return view('search.find', compact('results'));
    // }

    public function search(Request $request)
    {

        try{
            $keyword = $request->input('keyword');

            $playlists =Playlist::where('name','like', "%{$keyword}%")->get();

            return view('dashboard.videoplaylist_3min', compact('playlists'))->with('success', 'You Have Search Results');

        } catch(\Exception $error){
            $request->session()->flash('delete','Something goes wrong. Please try again');
            return back();
        }
    }

    public function search_5min(Request $request)
    {

        try{
            $keyword = $request->input('keyword');

            $playlists =Playlist::where('name','like',"%{$keyword}%")->get();

            return view('dashboard.videoplaylist_5min', compact('playlists'))->with('success', 'You Have Search Results');

        } catch(\Exception $error){
            $request->session()->flash('delete','Something goes wrong. Please try again');
            return back();
        }
    }

    public function password_check(Request $request)
    {
        $user = \DB::table('users')
          ->where('email', \Auth::user()->email)
          ->first();

        if (\Hash::check($request->password, $user->password)) {
          return response()->json([
            'success' => true
          ]);
        } else {
          return response()->json([
            'success' => false
          ]);
        }
      }


}
