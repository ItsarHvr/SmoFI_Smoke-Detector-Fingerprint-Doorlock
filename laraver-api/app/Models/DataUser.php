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
}
