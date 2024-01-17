<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAccess extends Model
{
    use HasFactory;
    protected $table = 'log_access';
    protected $fillable = [
        'user_name',
        'fingerprint_id',
        'access_date',
        'access_time',
        'access',
    ];
    
    protected $dates = ['access_time'];
    protected $primaryKey = 'access_id';

    public $timestamps = false;
}
