<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\DhBet;

class DhBetController extends Controller
{
    public function create(Request $request){
        try {
        $round =  DB::table('dh_bet')->orderBy('id', 'desc')->first();
        if( number_format($round->round) > number_format($request->round) )
            { 
                return response()->json(['response' => 'lower round'],200 ); 
            }
            DB::table('dh_bet')
            ->insert([
                'round' => $request->round,
                'account_name' => $request->account_name,
                'account_password' =>  $request->account_password,
                'status' =>  $request->status,
                
            ]);

            return response()->json(['response' => 'success'],200 ); 
        
        } catch (\Exception $error){
            return response()->json("Something goes wrong. Please try again", 400);
        }
    }
   
    public function dayData($day){
        try {
            $dayData =  DB::table('dh_bet')->where('created_at', 'LIKE', "%{$day}%")->get();

            return response()->json(['response' => 'success' ,  $dayData ],200);

        } catch (\Exception $error){
            return response()->json("Something goes wrong. Please try again", 400);
        }
    }
        
    public function latestBall(Request $request){
        try {
            $dayData =  DB::table('dh_bet')->orderBy('id', 'desc')->first();
            return response()->json(['response' => 'success' ,  $dayData ],200); 
             
        } catch (\Exception $error){
            return response()->json("Something goes wrong. Please try again", 400);
        }
    }
    
    public function roundId($id){
        try {
            $dayData =  DB::table('dh_bet')->where('round', $id)->get();
            return response()->json(['response' => 'success' ,  $dayData ],200); 
             
        } catch (\Exception $error){
            return response()->json("Something goes wrong. Please try again", 400);
        }
    }

    
}
