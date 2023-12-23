<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpMqtt\Client\MqttClient;

class MqttPublishJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $statusRelay;

    public function __construct($statusRelay)
    {
        $this->statusRelay = $statusRelay;
    }

    public function handle()
    {
        $server   = '192.168.100.4';
        $port     = 1883;
        $clientId = 'laravel';

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $mqtt->connect();
            $mqtt->publish('relay/status', json_encode(['statusRelay' => $this->statusRelay]));
            $mqtt->disconnect();
        } catch (\Exception $e) {
            // Handle exception, e.g., log error
            \Log::error('MQTT Publish Error: ' . $e->getMessage());
        }
    }
}
