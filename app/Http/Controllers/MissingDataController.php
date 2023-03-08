<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissingDataController extends Controller
{

    public function show(Request $request, $type)
    {
        $data['game_type'] = $type;
        return view('dashboard.add_missing_data', $data);
    }

}
