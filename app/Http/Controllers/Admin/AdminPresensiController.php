<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

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
}
