<?php

namespace App\Http\Controllers;

use App\Models\Door;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Exceptions\ConnectException;
use PhpMqtt\Client\Exceptions\ConnectionException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\Exceptions\PublishException;
use PhpMqtt\Client\Exceptions\SubscribeException;

class DoorController extends Controller
{
    public function index()
    {
        $statusRelay = Door::latest()->value('status');

        return view('door', compact('statusRelay'));
    }

    public function perbaruiStatusRelay(Request $request)
    {
        try {
        $statusRelay = ($request->input('switch') == 'on') ? 1 : 0;
        Door::create(['status' => $statusRelay]);

        $this->publishToMqtt($statusRelay);

        $this->cleanupDatabase();
        return redirect()->route('door');

        } catch (\Exception $e) {
            // Log the error
            \Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getStatusRelayJson()
    {
        $statusRelay = Door::latest()->value('status');

        return response()->json(['statusRelay' => $statusRelay]);
    }

    private function publishToMqtt($statusRelay)
    {
        $server   = 'localhost';
        $port     = 1883;
        $clientId = 'laravel';
        
        $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        // Connect to the MQTT broker
        $mqtt->connect();

        // Publish the status to the specified topic
        $mqtt->publish('pbl/relay', json_encode(['statusRelay' => $statusRelay]));
    }
    
    private function cleanupDatabase()
    {
        $recordCount = Door::count();

        // Define the maximum number of records to keep (e.g., 50)
        $maxRecords = 50;

        if ($recordCount > $maxRecords) {
            // Calculate how many records to delete
            $recordsToDelete = $recordCount - $maxRecords;

            // Delete the oldest records
            Door::oldest()->take($recordsToDelete)->delete();
        }
    }
}