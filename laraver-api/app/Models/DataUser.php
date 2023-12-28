<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;
use Illuminate\Notifications\Notifiable;

class DataUser extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use AuthenticatableTrait, AuthorizableTrait, HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password'];

    // Mutator untuk menyimpan password yang di-hash
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getUserData($userId)
    {
        // Implementasikan logika untuk mendapatkan data pengguna berdasarkan $userId
        $user = DataUser::find($userId);

        if ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                // Tambahkan atribut lainnya sesuai kebutuhan
            ];
        }

        return null;
    }

    public function updateProfile($userId, $data)
    {
        $user = DataUser::find($userId);

        if ($user) {
            // Update nama jika disediakan
            if (isset($data['name'])) {
                $user->name = $data['name'];
            }

            // Update email jika disediakan
            if (isset($data['email'])) {
                $user->email = $data['email'];
            }

            // Update password jika disediakan
            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            return true; // Profil berhasil diperbarui
        }

        return false; // Gagal menemukan pengguna
    }
}
