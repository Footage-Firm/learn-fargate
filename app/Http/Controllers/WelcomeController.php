<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function app()
    {
        $teams = ['team 1', 'team 2'];
        return view('app', compact('teams'));
    }
}
