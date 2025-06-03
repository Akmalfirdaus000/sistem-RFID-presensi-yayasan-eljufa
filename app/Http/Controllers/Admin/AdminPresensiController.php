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
    $users = User::where('role', '!=', 'admin')
        ->when($request->filled('search_name'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search_name . '%');
        })
        ->with(['attendances' => function ($q) use ($request) {
            if ($request->filled('search_date')) {
                $q->where('tanggal', $request->search_date);
            }
            if ($request->filled('search_status')) {
                $q->where('status', $request->search_status);
            }
            $q->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->take(5);
        }])
        ->get();

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
            // Filter tanggal jika tersedia
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('tanggal', [
                    Carbon::parse($request->start_date),
                    Carbon::parse($request->end_date),
                ]);
            }

            // Ambil 5 presensi terbaru berdasarkan tanggal dan waktu dibuat
            $q->orderBy('tanggal', 'desc')
              ->orderBy('created_at', 'desc')
              ->take(5);
        }])
        ->get();

    return view('admin.riwayat.index', compact('users'));
}





}
