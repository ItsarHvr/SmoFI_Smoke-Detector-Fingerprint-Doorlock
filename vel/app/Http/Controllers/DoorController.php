<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\door;

class DoorController extends Controller
{
    public function index()
    {
        // Retrieve the current relay state from the database
        $relayState = Door::where('id', 1)->value('status');

        return view('door', compact('relayState'));
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'switch' => 'required|in:0,1',
        ]);

        try {
            // Handle form submission
            $relayState = $request->input('switch');

            // Update the database using Eloquent
            Door::where('id', 1)->update(['status' => $relayState]);

            return redirect()->route('door')->with('status', 'Record updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('door')->with('error', 'Error updating record: ' . $e->getMessage());
        }
    }
}
