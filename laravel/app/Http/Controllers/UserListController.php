<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserListController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('userlist', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('userlistEdit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'id_fingerprint' => 'nullable|integer|max:255',
            // Add other validation rules as needed
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'id_fingerprint' => $request->input('id_fingerprint'),
            // Add other columns as needed
        ]);

        return redirect()->route('userlist.index')->with('status', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('userlist.index')->with('status', 'User deleted successfully');
    }
}
