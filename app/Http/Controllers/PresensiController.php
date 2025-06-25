<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); // Pastikan user sudah login
        
        $searchDate = $request->input('search_date');

        // $searchDate = $request->input('search_date', Carbon::today()->toDateString());

        // Ambil data perusahaan
        $company = Company::first();

        // Pastikan work_time tidak kosong, lalu pecah berdasarkan tanda "-"
        if ($company && $company->work_time) {
            $workTimeParts = explode('-', $company->work_time);
            $jamMasuk = $workTimeParts[0] ?? '08:00';
            $jamKeluar = $workTimeParts[1] ?? '17:00';
        } else {
            $jamMasuk = '08:00';
            $jamKeluar = '17:00';
        }

        // Ambil data presensi user untuk hari ini
        $attendance = Attendance::where('id_user', $user->id)
            ->whereDate('tanggal', $searchDate)
            ->first();

        // Tentukan status kehadiran
        $statusKehadiran = 'Belum Absen';
        if ($attendance) {
            $statusKehadiran = ucfirst($attendance->status);
        }

        // Ambil semua presensi berdasarkan user yang login
   $query = Attendance::where('id_user', $user->id)->orderBy('tanggal', 'desc');

if ($searchDate) {
    $query->whereDate('tanggal', $searchDate);
}

$attendances = $query->paginate(5  )->appends(['search_date' => $searchDate]);




        return view('user.presensi.index', compact(
            'attendances',
            'user',
            'searchDate',
            'jamMasuk',
            'jamKeluar',
            'statusKehadiran'
        ));
    }
    public function getRiwayatUser(Request $request)
{
    // Ambil ID pengguna yang sedang login
    $userId = Auth::id();

    // Ambil nilai pencarian tanggal dari request
    $searchDate = $request->input('search_date');

    // Ambil data presensi berdasarkan user login dan filter berdasarkan tanggal jika ada
    $riwayatPresensi = Attendance::where('id_user', $userId)
        ->when($searchDate, function ($query, $searchDate) {
            return $query->whereDate('tanggal', $searchDate);
        })
        ->orderBy('tanggal', 'desc')
        ->paginate(5)
        ->appends(['search_date' => $searchDate]); // Pastikan filter tetap saat pindah halaman

    // Kirim data ke view
    return view('user.riwayat.index', compact('riwayatPresensi', 'searchDate'));
}

    public function getDetailPresensi($id)
{
    $attendance = Attendance::findOrFail($id);

    return response()->json([
        'tanggal' => $attendance->tanggal,
        'status' => ucfirst($attendance->status),
        'jam_masuk' => $attendance->jam_masuk,
        'jam_keluar' => $attendance->jam_keluar,
    ]);
}


}
