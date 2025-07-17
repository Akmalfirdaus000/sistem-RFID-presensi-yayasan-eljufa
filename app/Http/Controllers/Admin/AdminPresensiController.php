<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPresensiController extends Controller
{
public function index(Request $request)
{
    // Ambil parameter filter
    $searchName = $request->search_name;
    $startDate = $request->start_date;
    $endDate = $request->end_date;
    $statusKehadiran = $request->search_status; // Hadir, Tidak Hadir, dsb
    $filterWaktu = $request->filter_waktu; // 'terlambat', 'lembur', atau null

    // Query data user dan presensi
    $users = User::where('role', '!=', 'admin')
        ->when($searchName, function ($q) use ($searchName) {
            $q->where('name', 'like', '%' . $searchName . '%');
        })
        ->with(['attendances' => function ($q) use ($startDate, $endDate, $statusKehadiran) {
            if ($startDate) {
                $q->whereDate('tanggal', '>=', $startDate);
            }
            if ($endDate) {
                $q->whereDate('tanggal', '<=', $endDate);
            }
            if ($statusKehadiran) {
                $q->where('status', $statusKehadiran);
            }
            $q->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');
        }])
        ->get();

    // Ambil jam masuk normal dan jam keluar normal
    $jamMasukNormal = Carbon::createFromTimeString('08:00:00');
    $jamKeluarNormal = Carbon::createFromTimeString('17:00:00');

    // Proses filter tambahan: keterlambatan dan lembur
    if ($filterWaktu == 'terlambat' || $filterWaktu == 'lembur') {
        $users = $users->filter(function ($user) use ($filterWaktu, $jamMasukNormal, $jamKeluarNormal) {
            $user->attendances = $user->attendances->filter(function ($att) use ($filterWaktu, $jamMasukNormal, $jamKeluarNormal) {
                try {
                    $masuk = $att->jam_masuk ? Carbon::parse($att->jam_masuk) : null;
                    $keluar = $att->jam_keluar ? Carbon::parse($att->jam_keluar) : null;
                } catch (\Exception $e) {
                    return false;
                }

                if ($filterWaktu == 'terlambat') {
                    return $masuk && $masuk->gt($jamMasukNormal);
                }

                if ($filterWaktu == 'lembur') {
                    return $keluar && $keluar->gt($jamKeluarNormal);
                }

                return false;
            });

            // Hanya tampilkan user yang punya presensi sesuai filter
            return $user->attendances->count() > 0;
        });
    }

    return view('admin.presensi.index', compact('users'));
}



public function riwayat(Request $request)
{
    // Ambil semua user non-admin dengan presensi terbaru
    $users = User::where('role', '!=', 'admin')
        ->when($request->filled('search_name'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        })
        ->with(['attendances' => function ($q) use ($request) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('tanggal', [
                    Carbon::parse($request->start_date),
                    Carbon::parse($request->end_date),
                ]);
            }

            $q->orderBy('tanggal', 'desc')
              ->orderBy('created_at', 'desc')
              ->take(5);
        }])
        ->get();

    return view('admin.riwayat.index', compact('users'));
}





}
