<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rfid;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\AttendanceUpdated; // Tambahkan event Pusher

class AttendanceController extends Controller
{
 public function store(Request $request)
{
    Log::info('Menerima request absensi', ['request' => $request->all()]);

    $request->validate([
        'rfid' => 'required|string'
    ]);

    // Cari RFID di database
    $rfid = Rfid::where('rfid', $request->rfid)->first();
    if (!$rfid) {
        Log::error('RFID tidak ditemukan', ['rfid' => $request->rfid]);
        return response()->json([
            'status' => 'error',
            'message' => 'Kartu RFID Anda belum terdaftar'
        ], 404);
    }

    // Cari user berdasarkan RFID
    $user = User::where('id_rfid', $rfid->id_rfid)->first();
    if (!$user) {
        Log::error('User tidak ditemukan untuk RFID ini', ['id_rfid' => $rfid->id_rfid]);
        return response()->json([
            'status' => 'error',
            'message' => 'User tidak ditemukan untuk kartu ini'
        ], 404);
    }

    Log::info('User ditemukan', ['user' => $user->toArray()]);

    // Cek apakah user sedang izin/cuti
    $izinCuti = Attendance::where('id_user', $user->id)
        ->whereDate('tanggal', Carbon::today()->toDateString())
        ->whereIn('status', ['izin', 'cuti'])
        ->exists();

    if ($izinCuti) {
        Log::warning('User mencoba scan saat sedang izin/cuti', ['id_user' => $user->id]);
        return response()->json([
            'status' => 'error',
            'message' => 'Anda sedang izin/cuti. Tidak dapat melakukan scan kartu.'
        ], 403);
    }

    // Cek jumlah scan hari ini
    $scanCount = Attendance::where('id_user', $user->id)
        ->whereDate('tanggal', Carbon::today()->toDateString())
        ->count();

    // Jika sudah scan 2x, tolak scan berikutnya
    if ($scanCount >= 2) {
        Log::warning('User mencoba scan lebih dari batas maksimal', ['id_user' => $user->id]);
        return response()->json([
            'status' => 'error',
            'message' => 'Anda sudah mencatat jam masuk dan keluar hari ini. Silakan scan kembali besok.'
        ], 400);
    }

    // Cek absensi terakhir user hari ini
    $attendance = Attendance::where('id_user', $user->id)
        ->whereDate('tanggal', Carbon::today()->toDateString())
        ->orderBy('created_at', 'desc')
        ->first();

    // Jika ini scan pertama (jam masuk)
    if (!$attendance || ($attendance && $scanCount == 0)) {
        Log::info('Mencatat jam masuk baru', ['id_user' => $user->id]);

        $newAttendance = Attendance::create([
            'id_attendance' => Str::uuid(),
            'id_user' => $user->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_masuk' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
            'status' => 'hadir',
        ]);

        Log::info('Event AttendanceUpdated dikirim ke Pusher', ['attendance' => $newAttendance]);
        event(new AttendanceUpdated($newAttendance));

        return response()->json([
            'status' => 'success',
            'message' => 'Kehadiran tercatat. Silakan tap lagi untuk mencatat jam keluar.',
            'attendance' => $newAttendance
        ], 200);
    }

    // Jika sudah ada absen masuk tapi belum ada jam keluar, tap kedua mencatat jam keluar
    if ($attendance && is_null($attendance->jam_keluar) && $scanCount == 1) {
        Log::info('Mencatat jam keluar', ['id_attendance' => $attendance->id_attendance]);

        $attendance->update([
            'jam_keluar' => Carbon::now('Asia/Jakarta')->format('H:i:s')
        ]);

        Log::info('Event AttendanceUpdated dikirim ke Pusher', ['attendance' => $attendance]);
        event(new AttendanceUpdated($attendance));

        return response()->json([
            'status' => 'success',
            'message' => 'Jam keluar tercatat. Absensi Anda telah selesai untuk hari ini.'
        ], 200);
    }

    Log::warning('User mencoba scan setelah mencapai batas maksimal', ['id_user' => $user->id]);
    return response()->json([
        'status' => 'error',
        'message' => 'Anda sudah mencatat jam masuk dan keluar hari ini. Silakan scan kembali besok.'
    ], 400);
}



public function ajukanIzin(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'status' => 'required|in:izin,cuti',
        'keterangan' => 'required|string|max:255',
        'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Pastikan user login
    $user = Auth::user();
    if (!$user) {
        Log::error('User tidak ditemukan saat mengajukan izin');
        return response()->json([
            'status' => 'error',
            'message' => 'Anda harus login untuk mengajukan izin.'
        ], 401);
    }
    $user = Auth::user();

    // Simpan file lampiran jika ada
    $lampiranPath = null;
    if ($request->hasFile('lampiran')) {
        $lampiranPath = $request->file('lampiran')->store('izin', 'public');
        Log::info('Lampiran berhasil disimpan:', ['path' => $lampiranPath]);
    }
    // Simpan file foto jika ada
    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
        $fotoPath = $request->file('foto')->storeAs('izin', $fileName, 'public');
        Log::info('Foto berhasil disimpan:', ['path' => $fotoPath]);
    } else {
        Log::warning('Tidak ada foto yang diterima di request.');
    }


    // Simpan data izin/cuti ke database
    $attendance = Attendance::create([
        'id_attendance' => (string) Str::uuid(),
        'id_user' => $user->id,  // PASTIKAN MENGGUNAKAN $user->id, BUKAN $user->id_user
        'tanggal' => $request->tanggal,
        'jam_masuk' => null,
        'jam_keluar' => null,
        'status' => $request->status,
        'keterangan' => $request->keterangan,
        'lampiran' => $lampiranPath,
        'foto' => $fotoPath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Kirim event ke Pusher
    broadcast(new AttendanceUpdated($attendance))->toOthers();

    return response()->json([
        'message' => 'Izin/Cuti berhasil diajukan!',
        'data' => $attendance
    ], 200);
}



}
