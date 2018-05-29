<?php

namespace App\Http\Controllers;

use App\Team;

class WelcomeController extends Controller
{
    public function app()
    {
        $teams = Team::all();
        return view('app', compact('teams'));
    }
}
