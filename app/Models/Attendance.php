<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
 protected $table = 'attendances';
    protected $primaryKey = 'id_attendance';
    public $incrementing = false;
    protected $keyType = 'string';

    // protected $fillable = [
    //     'id_attendance', 'id_user', 'tanggal', 'jam_masuk', 'jam_keluar', 'status'
    // ];
    protected $fillable = [
    'id_attendance', 'id_user', 'tanggal', 'jam_masuk', 'jam_keluar',
    'status', 'keterangan', 'lampiran', 'foto', 'created_at', 'updated_at'
];


    // Relasi ke User
 public function user()
{
    return $this->belongsTo(User::class, 'id_user', 'id'); // ✅ Benar
}

    
}
