<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-role');
    }

    public function index(){
        $page = "Master Data Role";
        return view('roles.index', compact('page'));
    }
}
