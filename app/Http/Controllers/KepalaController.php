<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class KepalaController extends Controller
{
    //

public function listPengguna(Request $request)
{
    $query = User::query();

    // Filter pencarian jika ada input 'search'
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('jabatan', 'like', "%$search%");
        });
    }

    // Ambil data dengan pagination
    $users = $query->orderBy('name')->paginate(10);

    // Kirim ke view
    return view('kepala.pengguna.index', compact('users'));
}
public function laporanHarian(Request $request)
{
    $tanggal = $request->input('tanggal', now()->toDateString());
    $status = $request->input('status', 'semua');
    $users = User::with(['attendances' => function ($query) use ($tanggal) {
        $query->whereDate('tanggal', $tanggal);
    }])->get();

    return view('kepala.laporan.harian', compact('users', 'tanggal', 'status'));
}

public function laporanBulanan(Request $request)
{
    $bulan = (int) $request->input('bulan', now()->month);
    $tahun = (int) $request->input('tahun', now()->year);
    $tanggalAwal = Carbon::create($tahun, $bulan, 1);
    $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
    $tanggalPeriode = CarbonPeriod::create($tanggalAwal, $tanggalAkhir);

    $users = User::with(['attendances' => function ($query) use ($tanggalAwal, $tanggalAkhir) {
        $query->whereBetween('tanggal', [$tanggalAwal->toDateString(), $tanggalAkhir->toDateString()]);
    }])->get();

    return view('kepala.laporan.bulanan', compact(
        'users', 'bulan', 'tahun', 'tanggalAwal', 'tanggalAkhir', 'tanggalPeriode'
    ));
}
}
