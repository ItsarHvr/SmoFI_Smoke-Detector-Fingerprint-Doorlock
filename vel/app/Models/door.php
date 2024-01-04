<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class door extends Model
{
    use HasFactory;
    protected $table = 'doors';
    protected $fillable = ['status'];
    public $timestamps = false;
}
