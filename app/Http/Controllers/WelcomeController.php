<?php

namespace App\Http\Controllers;

use App\Team;

class WelcomeController extends Controller
{
    public function teams()
    {
        $teams = Team::all();
        return view('teams', compact('teams'));
    }

    public function progress()
    {
        $teams = Team::all();
        return view('progress', compact('teams'));
    }
}
