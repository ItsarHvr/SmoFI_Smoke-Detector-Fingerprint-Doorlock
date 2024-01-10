<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnrollController extends Controller
{
    public function edit($id)
    {
        // Assuming you are retrieving a user from the database or some other source
        $user = User::findOrFail($id);
        return view('enrollEdit', compact('user'));
    }

    public function index()
    {
        return view('enroll');
    }
}
