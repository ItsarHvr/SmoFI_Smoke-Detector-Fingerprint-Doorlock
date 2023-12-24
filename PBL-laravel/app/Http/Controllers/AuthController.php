<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Menggunakan Eloquent untuk mendapatkan user berdasarkan email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Memeriksa apakah password cocok menggunakan fungsi check() Eloquent
            if (password_verify($password, $user->password)) {
                // Login berhasil
                session_start();
                $_SESSION["user_id"] = $user->id;
                $_SESSION["full_name"] = $user->full_name;

                return redirect('/dashboard');
            } else {
                // Password tidak cocok
                return redirect('/login')->with('error', 'Invalid email or password');
            }
        } else {
            // User tidak ditemukan
            return redirect('/login')->with('error', 'User not found');
        }
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            ],[
            'required' => 'Semua formulir wajib diisi.',
            ]);

        $role = $request->input('role', null);
        User::create([
            'full_name' => $request->fullname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $role, 
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }
}

