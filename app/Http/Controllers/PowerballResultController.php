<?php

namespace App\Http\Controllers;

use App\PowerballResult;
use Illuminate\Http\Request;
use App\PlaylistTrack;
use App\VideoList;
use Illuminate\Support\Facades\DB;

class PowerballResultController extends Controller
{

    /**
     * Get Poweball result - playlist ID, Track ID
     */

    public function getPlaylistTrackResult($playlistID,$trackID){
        $videoID=DB::table('playlist_tracks')->where('playlist_id',$playlistID)->where('track_id',$trackID)->value('video_id');
        $playlist=DB::table('playlists')->find($playlistID);
        if($playlist->type == "3min"){
            $videoResult=json_encode(DB::table('three_min_video_lists')->find($videoID));
        }

        if($playlist->type == "5min"){
            $videoResult=json_encode(DB::table('five_min_video_lists')->find($videoID));
        }

        return $videoResult;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\PowerballResult  $powerballResult
     * @return \Illuminate\Http\Response
     */
    public function show(PowerballResult $powerballResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PowerballResult  $powerballResult
     * @return \Illuminate\Http\Response
     */
    public function edit(PowerballResult $powerballResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PowerballResult  $powerballResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PowerballResult $powerballResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PowerballResult  $powerballResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(PowerballResult $powerballResult)
    {
        //
    }
}
