<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ApiKey;
use App\Helpers\ApiKeyGenerateHelper;
use Illuminate\Support\Facades\DB;

class ApiManagementController extends Controller
{
    private $host;

    public function __construct()
    {
        $this->middleware('auth');
        $this->host = env('WINNER_API_HOST');
    }

    public function index(){
     
        $response = Http::get($this->host.'apiKey/list');
      
        $apiKeyData = $response->json();

        return view('dashboard.api_management')->with('apiKeyData',$apiKeyData['data']);
    }

    public function create(Request $request){
   
        $request->validate([
            'ip_address' => 'required|ip'
          ]);

        try{
            $response = Http::post($this->host.'apiKey/create', [
                'type' => $request->get('game_type'),
                'ip' => $request->get('ip_address'),
                'status' => $request->get('status'),
            ]);
            $request->session()->flash('success','API key created.');
            return back();
        }catch(\Exception $error){
            $request->session()->flash('Something goes wrong. Please try again');
            return back();
        }
        
    }

    public function delete(Request $request,$id){
       
        try{
            $response = Http::get($this->host.'apiKey/delete?id='.$id);
            $request->session()->flash('delete','API key deleted.');
            return back();
        }catch(\Exception $error){
            $request->session()->flash('Something goes wrong. Please try again');
            return back();
        }
        
    }

    public function testIPRestriction()
    {
        $response = Http::get($this->host.'apiKey/list');
      
        $apiKeyData = $response->json();
    }

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
