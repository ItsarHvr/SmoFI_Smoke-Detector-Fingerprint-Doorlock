<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use App\Models\RelayStatus;
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
                $mqtt->subscribe('relay/status', function ($topic, $message, $retained, $matchedWildcards) {
                    // Update the relay status in the database
                    $statusRelay = json_decode($message)->statusRelay;
                    RelayStatus::create(['status' => $statusRelay]);

                    // Additional logic as needed

                    // Optionally log the update
                    Log::info('Relay status updated: ' . $statusRelay);
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
}
