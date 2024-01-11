<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DataUser;

class DataUserProfile
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function getUserData()
    {
        // Implementasikan logika untuk mendapatkan data pengguna berdasarkan $this->userId
        $user = DataUser::find($this->userId);

        if ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                // Tambahkan atribut lainnya sesuai kebutuhan
            ];
        }

        return null;
    }
}
