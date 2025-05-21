<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPresensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user');

        // Filter berdasarkan nama
        if ($request->has('search_name') && $request->search_name != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_name . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('search_date') && $request->search_date != '') {
            $query->where('tanggal', $request->search_date);
        }

        // Filter berdasarkan status
        if ($request->has('search_status') && $request->search_status != '') {
            $query->where('status', $request->search_status);
        }

        $attendances = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('admin.presensi.index', compact('attendances'));
    }
    public function riwayat(Request $request)
    {
        $query = Attendance::with('user');

        // Filter berdasarkan nama karyawan
        if ($request->filled('search_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_name . '%');
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        // Mengatur urutan data dan paginasi
        $attendances = $query->orderBy('tanggal', 'desc')->paginate(10);

        // Mengembalikan view dengan data presensi
        return view('admin.riwayat.index', compact('attendances'));
    }
}
