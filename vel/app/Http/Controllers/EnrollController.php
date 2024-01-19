<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EnrollController extends Controller
{
    public function enroll($id)
{
    $user = User::findOrFail($id);
    return view('enroll', compact('user'));
}
    
   
}
