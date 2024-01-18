<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use App\Models\User;
use App\Models\Door;
use App\Models\FingerData;
use App\Models\LogAccess;
use App\Events\HelloEvent;
use App\Events\LogAccessEvent;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topic in the background';

    public function handle()
    {
        $server   = 'localhost';
        $port     = 1883;
        $clientId = 'laravel-subscriber';

        $mqtt = new MqttClient($server, $port, $clientId);

    while (true) {
        try {
            $mqtt->connect();

            $mqtt->subscribe('pbl/relay', function ($topic, $message, $retained, $matchedWildcards) {
                $statusRelay = json_decode($message)->statusRelay;
                Door::create(['status' => $statusRelay]);

                \Log::info('Relay status updated: ' . $statusRelay);
                broadcast(new HelloEvent($statusRelay));
            }, 0);

            $mqtt->subscribe('pbl/finger', function ($topic, $message, $retained, $matchedWildcards) {
                $fingerprintId = json_decode($message)->fingerprintId;
                $access = "Access Granted";
                FingerData::create([
                    'fingerprint_id' => $fingerprintId,
                    'access' => $access]);

                Log::info('Fingerprint ID received: ' . $fingerprintId);

                // Cocokkan dengan data pada tabel 'user'
                $user = User::where('fingerprint_id', $fingerprintId)->first();

                if ($user) {
                    // Jika cocok, masukkan nama ke tabel baru
                    $updatedLogAccess = [
                        'user_name' => $user->name,
                        'fingerprint_id'=>$fingerprintId,
                        'access_date' => Carbon::now()->toDateString(),
                        'access_time' => Carbon::now()->toTimeString(),
                        'access' => $access,
                    ];
                    $updatePaginate = 1;
    
    broadcast(new \App\Events\LogAccessEvent($updatedLogAccess, $updatePaginate, request()->page));
                    
                    LogAccess::create([
                        'user_name' => $user->name,
                        'fingerprint_id'=>$fingerprintId,
                        'access_date' => Carbon::now()->toDateString(),
                        'access_time' => Carbon::now()->toTimeString(),
                        'access' => $access,
                    ]);

                    \Log::info('Fingerprint ID received: ' . $fingerprintId . ', User Name: ' . $user->name);
                } else {
                    \Log::warning('Fingerprint ID not found in user table: ' . $fingerprintId);
                }
            }, 0);

            $mqtt->loop(true);
            $mqtt->disconnect();
            sleep(1);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            sleep(5);
        }
        }
    }

    private function cleanupDatabase()
    {
        $recordCount = FingerData::count();

        $maxRecords = 24;

        if ($recordCount > $maxRecords) {
            $recordsToDelete = $recordCount - $maxRecords;

            FingerData::oldest()->take($recordsToDelete)->delete();
        }
    }
}
