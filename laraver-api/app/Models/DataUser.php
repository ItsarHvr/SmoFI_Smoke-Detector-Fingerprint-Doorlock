<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DataUser extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password'];

    // Mutator untuk menyimpan password yang di-hash
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
