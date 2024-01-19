<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GasReading;

class SmokeDetectorController extends Controller
{
    public function insertReading()
{
    // Fetch data from the gas_readings table, ordered by ID in descending order
    $gasReadings = GasReading::orderBy('id', 'desc')->simplePaginate(6); // Adjust the number of items per page as needed

    return view('smoke', compact('gasReadings'));
}


    
}