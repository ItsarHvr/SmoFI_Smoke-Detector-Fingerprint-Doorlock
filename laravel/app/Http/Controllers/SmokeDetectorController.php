<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GasReading;

class SmokeDetectorController extends Controller
{
    public function index()
    {
        $gasReadings = GasReading::orderBy('id', 'desc')->paginate(6);

        return view('smoke', compact('gasReadings'));
    }

    public function getSmokeValueData(Request $request)
    {
        $perPage = 6;
        $SmokeValueData = GasReading::orderBy('id', 'desc')->paginate(6);($perPage);

        return response()->json($SmokeValueData);

    }
}