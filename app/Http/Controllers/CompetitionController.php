<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        session()->put('page_is_active', 'compotition');

        return view('competition.index');
    }
}
