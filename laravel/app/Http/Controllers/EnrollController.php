<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EnrollController extends Controller
{
    
    public function enroll($id)
    {
        $user = User::findOrFail($id);
        return view('enroll', compact('user'));
    }
    
    public function enroll_id(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'fingerprint_id' => $request->input('id_fingerprint'),
        // Add other columns as needed
        ]);

        $this->publishToMqtt($request->input('id_fingerprint'));

        return redirect()->route('userlist.index')->with('status', 'User updated successfully');
    }

    private function publishToMqtt($id)
    {
        $server   = 'localhost';
        $port     = 1883;
        $clientId = 'laravel';

        $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);

        try {
        // Connect to the MQTT broker
            $mqtt->connect();

        // Publish the ID to the specified topic
            $mqtt->publish('EnrollID', json_encode(['id' => $id],0));
        } catch (\Exception $e) {
            Log::error('Gagal terhubung ke broker MQTT: ' . $e->getMessage());
        // Tindakan jika gagal terhubung ke broker
            throw $e;
        } finally {
        // Close the MQTT connection
            $mqtt->disconnect();
        }
    }
   
}
