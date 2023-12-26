<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use App\Models\RelayStatus;
use App\Models\LogAccess;
use Illuminate\Support\Facades\Log;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topic in the background';

    public function handle()
    {
        $server   = '192.168.100.4';
        $port     = 1883;
        $clientId = 'laravel-subscriber';

        $mqtt = new MqttClient($server, $port, $clientId);

    while (true) {
        try {
            $mqtt->connect();

            $mqtt->subscribe('pbl/relay', function ($topic, $message, $retained, $matchedWildcards) {
                $statusRelay = json_decode($message)->statusRelay;
                RelayStatus::create(['status' => $statusRelay]);

                Log::info('Relay status updated: ' . $statusRelay);
            }, 0);

            $mqtt->subscribe('pbl/finger', function ($topic, $message, $retained, $matchedWildcards) {
                $fingerprintId = json_decode($message)->fingerprintId;
                $access = "dibuka dengan fingerprint";
                cleanupDatabase();
                LogAccess::create([
                    'fingerprint_id' => $fingerprintId,
                    'status' => $acces]);

                Log::info('Fingerprint ID received: ' . $fingerprintId);
            }, 0);

            $mqtt->loop(true);
            $mqtt->disconnect();
            sleep(1); // Delay before reconnecting
        } catch (\Exception $e) {
            // Handle the exception, e.g., log the error
            Log::error('Error: ' . $e->getMessage());
            sleep(5); // Delay before attempting to reconnect
        }
        }
    }
    private function cleanupDatabase()
    {
        $recordCount = LogAccess::count();

        // Define the maximum number of records to keep (e.g., 50)
        $maxRecords = 24;

        if ($recordCount > $maxRecords) {
            // Calculate how many records to delete
            $recordsToDelete = $recordCount - $maxRecords;

            // Delete the oldest records
            LogAccess::oldest()->take($recordsToDelete)->delete();
        }
    }
}
