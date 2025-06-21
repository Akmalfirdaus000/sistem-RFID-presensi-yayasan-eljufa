<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RfidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('rfids')->insert([
            ['id_rfid' => 'EL-001', 'rfid' => 'RFID001', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-002', 'rfid' => 'RFID002', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-003', 'rfid' => 'RFID003', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-004', 'rfid' => 'RFID004', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-005', 'rfid' => 'RFID005', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-006', 'rfid' => 'RFID006', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-007', 'rfid' => 'RFID007', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-008', 'rfid' => 'RFID008', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id_rfid' => 'EL-009', 'rfid' => 'RFID009', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
