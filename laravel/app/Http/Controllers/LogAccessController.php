<?php

namespace App\Http\Controllers;

use App\Models\LogAccess;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Console\Commands\MqttSubscribe;

class DataAccessController extends Controller
{
    public function mergeAndStoreData(MqttSubscribe $mqttSubscribe)
    {
        $fingerprintId = $mqttSubscribe->getFingerprintId();
        // Ambil data dari model pertama (LogAccess)
        $logAccessData = LogAccess::where('id', $fingerprintId)->first();

        // Jika data tidak ditemukan, dapatkan data default atau lakukan penanganan lain sesuai kebutuhan
        if (!$logAccessData) {
            // Handle ketika data tidak ditemukan
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Dapatkan data dari model kedua (Siswa) berdasarkan ID
        $siswaData = Siswa::find($logAccessData->id);

        // Jika data tidak ditemukan, dapatkan data default atau lakukan penanganan lain sesuai kebutuhan
        if (!$siswaData) {
            // Handle ketika data tidak ditemukan
            return response()->json(['message' => 'Siswa data not found'], 404);
        }

        // Gabungkan data dari kedua model
        $mergedData = [
            'id' => $siswaData->id,
            'nama' => $siswaData->nama,
            'kelas' => $siswaData->kelas,
            'nim' => $siswaData->nim,
            'access' => $logAccessData->access,
        ];

        // Simpan data gabungan ke dalam tabel data_access
        DataAccess::create($mergedData);

        return response()->json(['message' => 'Data merged and stored successfully']);
    }
    
}
