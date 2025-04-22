<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'id_company' => 'EL-00', // Sesuaikan dengan ID perusahaan yang valid
            'id_rfid' => null, // Jika tidak ada RFID, set null
            'nik' => '1234567890123456',
            'name' => 'Akmal Firdaus',
            'jabatan' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'), // Enkripsi password
            'role' => 'admin',
            'photo' => null, // Jika tidak ada foto, set null
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
