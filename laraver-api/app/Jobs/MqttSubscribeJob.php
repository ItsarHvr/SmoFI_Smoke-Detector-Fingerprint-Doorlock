<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use PhpMqtt\Client\MqttClient;

class MqttSubscribeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $server   = '192.168.100.4';
        $port     = 1883;
        $clientId = 'laravel';

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $mqtt->connect();
            $mqtt->subscribe('relay/status', function ($topic, $message, $retained, $matchedWildcards) {
                // Update the relay status in the database
                $statusRelay = json_decode($message)->statusRelay;
                RelayStatus::create(['status' => $statusRelay]);

                // Additional logic as needed

                // Optionally log the update
                \Log::info('Relay status updated: ' . $statusRelay);
            }, 0);
            $mqtt->loop(true);
        } catch (\Exception $e) {
            // Handle exception, e.g., log error
            \Log::error('MQTT Subscribe Error: ' . $e->getMessage());
        }
    }
}
