<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\User;

class AdminRekapController extends Controller
{
    //
   public function index(Request $request)
    {

        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Ambil semua user dengan data absensi di bulan & tahun tertentu
        $users = User::with(['attendances' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun);
        }])->get();

        return view('admin.rekap.index', compact('users', 'bulan', 'tahun'));
    }
    public function rekapHarian(Request $request)
{
    $tanggal = $request->input('tanggal', Carbon::now()->toDateString());

    // Ambil semua user dengan absensi di tanggal tertentu
    $users = User::with(['attendances' => function ($query) use ($tanggal) {
        $query->whereDate('tanggal', $tanggal);
    }])->get();

    return view('admin.rekap.harian', compact('users', 'tanggal'));
}



}
