<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_company';  // Primary key string
    public $incrementing = false;  // Non-auto increment
    protected $keyType = 'string'; // String key

    protected $fillable = ['id_company', 'name', 'data', 'photo', 'work_time'];

    protected $casts = [
        'data' => 'array', // JSON akan otomatis dikonversi ke array
    ];
}
