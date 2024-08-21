<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;

class SeasonController extends Controller
{
    public function getRegister()
    {
        $seasons = Season::all();

        return view('register', compact('seasons'));
    }
}
