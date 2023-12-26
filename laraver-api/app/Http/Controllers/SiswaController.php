<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Exceptions\ConnectException;
use PhpMqtt\Client\Exceptions\ConnectionException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\Exceptions\PublishException;
use PhpMqtt\Client\Exceptions\SubscribeException;

class SiswaController extends Controller
{
    public function inputData(Request $request)
    {
        $statusRelay = ($request->input('switch') == 'on') ? 1 : 0;

        // Simpan data siswa ke database
        $siswa = new Siswa();
        $siswa->id = $request->input('id');
        $siswa->nama = $request->input('nama');
        $siswa->kelas = $request->input('kelas');
        $siswa->nim = $request->input('nim');
        $siswa->save();

        // Kirim ID siswa ke ESP8266 menggunakan MQTT
        $this->publishToMqtt($request->input('id'));

        return response()->json(['message' => 'Data siswa berhasil disimpan dan ID terkirim ke ESP8266'], 200);
    }

    private function publishToMqtt($id)
    {
        $server   = '192.168.100.4';
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

    public function view()
    {
        return view('input-data');
    }
}
