<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function __construct()
    {

    }

    public function maintenance()
    {
        $this->middleware('auth');
        $maintain_data = DB::table('maintain_games')->get();
        return view('dashboard.maintain_settings', compact('maintain_data'));
    }

    public function store()
    {
        DB::table('create_maintain_games')->update([
            ['game_type' => 'live_powerball', 'type' => '5min', 'maintain_status' => 'false'],
            ['game_type' => 'dh_powerball', 'type' => '5min', 'maintain_status' => 'false'],
            ['game_type' => 'dh_speed_kino', 'type' => '5min'],
            ['game_type' => 'live_powerball_ladder', 'type' => '5min'],
            ['game_type' => 'n_powerball', 'type' => '5min'],
            ['game_type' => 'n_powerball_ladder', 'type' => '5min'],
        ]);
    }

    public function updateMaintain(Request $request, $game_type, $type, $maintain_status, $maintain_type)
    {
        // dd($game_type, $type, $maintain_status);
        DB::table('maintain_games')
            ->where('game_type', $game_type)
            ->where('type', $type)
            ->update([
                'game_type' => $game_type,
                'type' => $type,
                'maintain_status' => $maintain_status,
                'maintain_type' => $maintain_type

            ]);


        // Redirect back to the original page
        return redirect()->back();
    }

    public function getMaintain(Request $request, $game_type, $type)
    {
        //get data
        $response = DB::table('maintain_games')->where('game_type',$game_type)->where('type',$type)->get();

        return $response;
    }

}
