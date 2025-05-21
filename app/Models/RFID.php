<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFID extends Model
{
    // Pastikan nama tabel diatur dengan benar
       protected $table = 'rfids';
   protected $primaryKey = 'id_rfid';
public $incrementing = false;
protected $keyType = 'string';


protected $fillable = [
    'id_rfid',
    'rfid',
    'status',
];
// Di dalam model RFID
public function user()
{
    return $this->hasOne(User::class, 'id_rfid', 'id_rfid');
}
}


