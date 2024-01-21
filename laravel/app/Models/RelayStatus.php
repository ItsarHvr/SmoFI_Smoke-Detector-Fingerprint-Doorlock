<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelayStatus extends Model
{
    protected $table = 'relay_status';
    protected $fillable = ['status'];
    use HasFactory;
}
