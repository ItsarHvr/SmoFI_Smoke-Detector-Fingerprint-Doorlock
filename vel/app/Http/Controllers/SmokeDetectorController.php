<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmokeDetectorController extends Controller
{
    public function index()
    {
        return view('smoke');
    }

    public function insertReading(Request $request)
    {
        $gasValue = $request->input('gas_value');

        GasReading::create([
            'gas_value' => $gasValue,
        ]);

        return response()->json(['message' => 'Data inserted successfully']);
    }
}