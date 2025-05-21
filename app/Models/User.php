<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class User extends Authenticatable

{

    // use HasFactory, Notifiable;
      use HasFactory, Notifiable, HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id'; // Konsisten dengan migrasi
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_company',
        'id_rfid',
        'nik',
        'name',
        'jabatan',
        'email',
        'password',
        'photo',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

     protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company', 'id_company');
    }

    // Relasi ke RFID
    public function rfid()
    {
        return $this->belongsTo(Rfid::class, 'id_rfid', 'id_rfid');
    }

    // Relasi dengan tabel Attendance
 public function attendances()
{
    return $this->hasMany(Attendance::class, 'id_user', 'id'); // ✅ Benar
}



}
