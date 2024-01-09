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
            'fingerprint_id' => 'nullable|string|max:255',
            // Tambahkan validasi sesuai kebutuhan lainnya
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'fingerprint_id' => $request->input('fingerprint_id'),
            // Tambahkan kolom lain sesuai kebutuhan
        ]);

        return redirect()->route('userlist.index')->with('status', 'User updated successfully');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return Redirect::route('userlist.index')
            ->with('status', 'User deleted successfully');
    }
}
