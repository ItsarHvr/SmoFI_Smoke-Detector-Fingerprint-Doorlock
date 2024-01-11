<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $role=Auth()->user()->role;

            if($role=='user')
            {
                return view('userdashboard');
            }
            else if($role=='admin')
            {
                return view('dashboard');
            }
            else
            {
                return redirect()->back();
            }
        }


    }
}
