<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.dashboardHome');
    }

    public function dashboardHome()
    {
        return view('dashboard.dashboardHome');
    }

    public function logout () {
        auth()->logout();
        return redirect('/');
    }

    public function unauthorizedAccess()
    {
        return view('dashboard.layouts.unauthorizedAccess');
    }

    public function showToken(){
        echo csrf_token(); 
      }
}
