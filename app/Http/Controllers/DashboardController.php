<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\RFID;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function user_dashboard()
    {
        return view('user.dashboard'); // Pastikan view ini ada di resources/views/dashboard/user.blade.php
    }

public function admin_dashboard()
{
    $totalRFID = RFID::count();
    $totalGuru = User::where('role', 'user')->count(); // Ganti 'guru' jika kamu pakai role lain
    $presensiTerbaru = Attendance::with('user')
        ->orderByDesc('tanggal')
        ->orderByDesc('created_at')
        ->limit(10)
        ->get();
    $tanggalHariIni = Carbon::now()->translatedFormat('l, d F Y');

    return view('admin.dashboard', compact(
        'totalRFID', 'totalGuru', 'presensiTerbaru', 'tanggalHariIni'
    ));
}


}
