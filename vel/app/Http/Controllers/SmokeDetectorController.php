<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GasReading;

class SmokeDetectorController extends Controller
{
    public function index()
    {
        return view('smoke');
    }

     public function insertGasReading(Request $request)
    {
        $gasValue = $request->input('gas_value');

        // Validasi jika $gasValue ada atau tidak, sesuai kebutuhan
        if (!$gasValue) {
            return response()->json(['error' => 'Invalid gas value'], 400);
        }

        try {
            // Menyimpan data ke database menggunakan Eloquent
            GasReading::create(['gas_value' => $gasValue]);

            return response()->json(['message' => 'Data inserted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error inserting data', 'details' => $e->getMessage()], 500);
        }
    }
}
