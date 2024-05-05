<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        session()->put('page_is_active', 'dashboard');

        return view('home.index');
    }
}
