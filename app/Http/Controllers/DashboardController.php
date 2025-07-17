<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\RFID;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

public function kepala_dashboard()
{
    $today = Carbon::today();
    $month = Carbon::now()->format('m');
    $year = Carbon::now()->format('Y');

    $harian = [
        'hadir' => Attendance::whereDate('tanggal', $today)->where('status', 'hadir')->count(),
        'absen' => Attendance::whereDate('tanggal', $today)->where('status', 'alpa')->count(),
        'cuti'  => Attendance::whereDate('tanggal', $today)->where('status', 'izin')->count(),
    ];

    $bulanan = Attendance::selectRaw('status, COUNT(*) as jumlah')
        ->whereMonth('tanggal', $month)
        ->whereYear('tanggal', $year)
        ->groupBy('status')
        ->pluck('jumlah', 'status');

    return view('kepala.dashboard', compact('harian', 'bulanan'));
}

    public function user_dashboard()
    {
        return view('user.dashboard');
    }

public function admin_dashboard()
{
    $totalRFID = RFID::count();
    $totalGuru = User::where('role', 'user')->count();
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
