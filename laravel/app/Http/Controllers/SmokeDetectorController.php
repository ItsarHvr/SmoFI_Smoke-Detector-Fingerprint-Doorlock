<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GasReading;

class SmokeDetectorController extends Controller
{
    public function index()
{
    // Fetch data from the gas_readings table, ordered by ID in descending order
    $gasReadings = GasReading::orderBy('id', 'desc')->simplePaginate(6);

    return view('smoke', compact('gasReadings'));
}
}