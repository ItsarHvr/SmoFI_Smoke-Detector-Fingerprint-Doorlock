<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserListController extends Controller
{
    public function index()
    {
         $users = User::paginate(10); // Change the number as per your requirements
    return view('userlist', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('userlistEdit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'id_fingerprint' => 'nullable|integer|max:255',
            // Add other validation rules as needed
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'id_fingerprint' => $request->input('id_fingerprint'),
            // Add other columns as needed
        ]);

        return redirect()->route('userlist.index')->with('status', 'User updated successfully');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $fingerprintId = $user->fingerprint_id;
            $user->delete();
            $this->publishToMqtt($fingerprintId);

            return redirect()->route('userlist.index')->with('status', 'User deleted successfully');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus pengguna: ' . $e->getMessage());
            return redirect()->route('userlist.index')->with('error', 'Failed to delete user');
        }
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
            $mqtt->publish('deleteId', json_encode(['id' => $id],0));
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
