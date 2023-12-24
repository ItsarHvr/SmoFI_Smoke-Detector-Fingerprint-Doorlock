<?php

namespace App\Http\Controllers;

use App\Models\RelayStatus;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Exceptions\ConnectException;
use PhpMqtt\Client\Exceptions\ConnectionException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\Exceptions\PublishException;
use PhpMqtt\Client\Exceptions\SubscribeException;

class RelayController extends Controller
{
    public function getStatusRelay()
    {
        $statusRelay = RelayStatus::latest()->value('status');

        return view('status-relay', compact('statusRelay'));
    }

    public function perbaruiStatusRelay(Request $request)
    {
        $statusRelay = ($request->input('switch') == 'on') ? 1 : 0;
        RelayStatus::create(['status' => $statusRelay]);

        $this->publishToMqtt($statusRelay);

        $this->cleanupDatabase();

        return redirect()->route('relay.status');
    }

    public function getStatusRelayJson()
    {
        $statusRelay = RelayStatus::latest()->value('status');

        return response()->json(['statusRelay' => $statusRelay]);
    }

    private function publishToMqtt($statusRelay)
    {
        $server   = '192.168.100.4';
        $port     = 1883;
        $clientId = 'laravel';
        
        $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        // Connect to the MQTT broker
        $mqtt->connect();

        // Publish the status to the specified topic
        $mqtt->publish('relay/status', json_encode(['statusRelay' => $statusRelay]));

    }
    private function cleanupDatabase()
    {
        $recordCount = RelayStatus::count();

        // Define the maximum number of records to keep (e.g., 50)
        $maxRecords = 50;

        if ($recordCount > $maxRecords) {
            // Calculate how many records to delete
            $recordsToDelete = $recordCount - $maxRecords;

            // Delete the oldest records
            RelayStatus::oldest()->take($recordsToDelete)->delete();
        }
    }
}