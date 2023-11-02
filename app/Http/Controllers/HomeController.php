<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-role');
    }

    public function index(){
        $page = 'Dashboard';
        return view('dashboard', compact('page'));
    }
}
