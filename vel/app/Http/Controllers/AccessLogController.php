<?php
// app/Http/Controllers/AccessLogController.php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function logAccess(Request $request)
    {
        $fingerprintId = $request->input('fingerprintID');
        AccessLog::create(['fingerprint_id' => $fingerprintId]);

        return response()->json(['status' => 'success']);
    }
    public function showLogs()
    {
        $logs = AccessLog::latest()->get();

        return view('access_logs', ['logs' => $logs]);
    }
}
