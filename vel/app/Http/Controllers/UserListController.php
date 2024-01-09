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
    // Update user logic here
}


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return Redirect::route('userlist.index')
            ->with('status', 'User deleted successfully');
    }
}
