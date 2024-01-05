<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmokeDetectorController extends Controller
{
    public function index()
    {
        return view('smoke');
    }
}
