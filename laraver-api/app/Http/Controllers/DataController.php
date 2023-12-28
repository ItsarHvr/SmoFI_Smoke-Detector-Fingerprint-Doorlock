<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DataUser::create($request->all());

        return redirect()->route('user.create')->with('success', 'User created successfully!');
    }

    public function login()
    {
        return view('user.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('user/dashboard');
        }

        return redirect()->route('user.login')->with('error', 'Invalid credentials. Please try again.');
    }

    public function index()
    {
    return view('user.dashboard');
    }

    public function profile()
    {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Membuat objek DataUser
        $dataUser = new DataUser();

        // Mendapatkan data pengguna
        $userData = $dataUser->getUserData(auth()->id());

        if ($userData) {
            $name = $userData["name"];
            $email = $userData["email"];
        } else {
            // Handle error or redirect to an error page
            return view('errors.profile-error');
        }

        return view('user.profile', compact('name', 'email'));
    }

    public function editProfile()
    {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Membuat objek DataUser
        $dataUser = new DataUser();

        // Fetch data pengguna
        $userData = $dataUser->getUserData(auth()->id());

        return view('user.edit-profile', compact('userData'));
    }

    public function updateProfile(Request $request)
    {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Handle form submission
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $dataUser = new DataUser();

        // Data yang akan diupdate
        $updateData = [];

        // Update nama jika disediakan
        if ($request->filled('name')) {
            $updateData['name'] = $request->input('name');
        }

        // Update email jika disediakan
        if ($request->filled('email')) {
            $updateData['email'] = $request->input('email');
        }

        // Update password jika disediakan
        if ($request->filled('password')) {
            $updateData['password'] = $request->input('password');
        }

        // Simpan perubahan ke profil pengguna
        $result = $dataUser->updateProfile(auth()->id(), $updateData);

        if ($result) {
            return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
        }

        return redirect()->route('user.profile')->with('error', 'Failed to update profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')->with('success', 'You have been logged out.');
    }
}
