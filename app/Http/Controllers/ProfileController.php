<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function create()
    {
        return view('profile.create');
    }

    public function load()
    {
        return view('profile.load');
    }

    public function selectClub()
    {
        return view('profile.select-club');
    }
}
