<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Absen extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $users = User::where('role', 'user')->get();

    foreach ($users as $user) {
        DB::table('attendances')->insert([
            'id_attendance' => Str::uuid(),
            'id_user' => $user->id,
            'keterangan' => 'Masuk kerja',
            'lampiran' => null,
            'foto' => null,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => '07:30:00',
            'jam_keluar' => '15:30:00',
            'status' => 'hadir',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    }

}
