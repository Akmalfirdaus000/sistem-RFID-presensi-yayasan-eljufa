<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RFID;
use App\Models\Attendance;
use Illuminate\Http\Request;

class RFIDController extends Controller
{
   public function registerRFID(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id_user',
        'rfid_uid' => 'required|exists:rfids,rfid'
    ]);

    $user = User::where('id_user', $request->user_id)->first();

    if ($user) {
        $user->id_rfid = $request->rfid_uid;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'RFID berhasil terdaftar pada user'
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'User tidak ditemukan'
    ]);
}

    public function getUserByRFID(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required'
        ]);

        $rfid = RFID::where('rfid', $request->rfid_uid)->first();

        if (!$rfid) {
            return response()->json([
                'status' => 'failed',
                'message' => 'RFID tidak ditemukan'
            ], 404);
        }

        $user = $rfid->user;

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'RFID belum terdaftar pada user'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'RFID dikenali',
            'user' => $user
        ]);
    }

    public function addAttendance(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id_user',
            'status' => 'required|in:hadir,absen,cuti'
        ]);

        $attendance = Attendance::create([
            'id_attendance' => uniqid(),
            'id_user' => $request->user_id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => now()->toTimeString(),
            'jam_keluar' => null,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance berhasil ditambahkan',
            'attendance' => $attendance
        ]);
    }
}
