<?php

use Database\Seeders\absen;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\RfidSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\CompanySeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
   public function run(): void
    {
         $this->call([
        CompanySeeder::class,
         RfidSeeder::class,
        //  Absen::class,
    ]);
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-001',
                'nik' => '1302044906060005',
                'name' => 'Ikhlas, S.Pd.',
                'jabatan' => 'Guru Seni',
                'email' => 'iklas@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => null,
                'nik' => null,
                'name' => 'Akmal Firdaus, S.Kom.',
                'jabatan' => null,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-002',
                'nik' => '1234567891111111',
                'name' => 'Nunun, M.Pd.',
                'jabatan' => 'Guru Bahasa',
                'email' => 'nunun@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user',
                'photo' => 'storage/profile/nunun.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-003',
                'nik' => '9876543211234567',
                'name' => 'Satria Hidayat, S.Pd.',
                'jabatan' => 'Guru Olahraga',
                'email' => 'satria@gmail.com',
                'password' => Hash::make('password3'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-004',
                'nik' => '1122334455667788',
                'name' => 'Rina Amelia, M.T.',
                'jabatan' => 'Guru TIK',
                'email' => 'rina@gmail.com',
                'password' => Hash::make('password4'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-005',
                'nik' => '5566778899001122',
                'name' => 'Fajar Pratama, S.Si.',
                'jabatan' => 'Guru Matematika',
                'email' => 'fajar@gmail.com',
                'password' => Hash::make('password5'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-006',
                'nik' => '6677889900112233',
                'name' => 'Dewi Sartika, S.Pd.',
                'jabatan' => 'Guru PKN',
                'email' => 'dewi@gmail.com',
                'password' => Hash::make('password6'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-007',
                'nik' => '7788990011223344',
                'name' => 'Budi Santoso, M.Kom.',
                'jabatan' => 'Guru RPL',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('password7'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-008',
                'nik' => '8899001122334455',
                'name' => 'Sri Wahyuni, S.S.',
                'jabatan' => 'Guru Bahasa Inggris',
                'email' => 'sri@gmail.com',
                'password' => Hash::make('password8'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'id_company' => 'EL-00',
                'id_rfid' => 'EL-009',
                'nik' => '9900112233445566',
                'name' => 'Hasan Basri, S.Ag.',
                'jabatan' => 'Guru Agama',
                'email' => 'hasan@gmail.com',
                'password' => Hash::make('password9'),
                'role' => 'user',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
         $this->call([
        Absen::class,
    ]);

    }
}
