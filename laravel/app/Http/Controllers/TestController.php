<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogAccess;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TestController extends Controller
{
    public function testLogAccess()
    {
            $fingerprintId = '2';
            $access = "dibuka dengan fingerprint";

            // Cari user berdasarkan fingerprint ID
            $user = User::where('fingerprint_id', $fingerprintId)->first();

            if ($user) {
                // Jika user ditemukan, simpan data ke dalam LogAccess
                LogAccess::create([
                    'user_name' => $user->name,
                    'fingerprint_id'=>$fingerprintId,
                    'access_date' => Carbon::now()->toDateString(),
                    'access_time' => Carbon::now()->toTimeString(),
                    'access' => $access,
                ]);

                Log::info('LogAccess record created for user: ' . $user->name);
            } else {
                Log::warning('User not found for fingerprint ID: ' . $fingerprintId);
            }

            return response()->json(['message' => 'Test success']);
    }
}
