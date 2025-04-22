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

}


