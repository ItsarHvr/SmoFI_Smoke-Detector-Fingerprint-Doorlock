<?php
// app/Http/Controllers/AccessLogController.php

namespace App\Http\Controllers;

use App\Models\LogAccess;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{   
    public function showLogs()
    {
        // Gantilah ini dengan cara Anda mengambil data dari model LogAccess
        $logAccesses = LogAccess::paginate(15);

        return view('logs', compact('logAccesses'));
    }

    public function getLogAccessData(Request $request)
    {
        $perPage = 15;
        $logAccessData = LogAccess::paginate($perPage);

        return response()->json($logAccessData);

    }
}
