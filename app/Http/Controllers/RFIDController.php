<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RFID;
use App\Models\Attendance;
use Illuminate\Http\Request;

class RFIDController extends Controller
{
    // Mendaftarkan RFID ke User
   public function registerRFID(Request $request)
{
    // Validasi ID dan UID RFID
    $request->validate([
        'user_id' => 'required|exists:users,id_user', // Pastikan id_user adalah UUID
        'rfid_uid' => 'required|exists:rfids,rfid'
    ]);

    $user = User::where('id_user', $request->user_id)->first();

    // Proses setelah data user ditemukan
    if ($user) {
        // Lakukan pengolahan data, misalnya menyimpan UID RFID pada user
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

    // Mendapatkan user berdasarkan RFID UID
    public function getUserByRFID(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required'
        ]);

        // Cari RFID
        $rfid = RFID::where('rfid', $request->rfid_uid)->first();

        if (!$rfid) {
            return response()->json([
                'status' => 'failed',
                'message' => 'RFID tidak ditemukan'
            ], 404);
        }

        // Cari user berdasarkan RFID
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

    // Menambahkan Kehadiran (Attendance)
    public function addAttendance(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id_user',
            'status' => 'required|in:hadir,absen,cuti'
        ]);

        // Menambahkan data attendance
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
