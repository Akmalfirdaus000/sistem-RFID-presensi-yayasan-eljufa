<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserUserController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();
        return view('profile.profile', compact('user'));
    }

    public function profile_change_name(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|string',
        ]);

        try {
            Auth::user()->update([
                'name' => $valid['name'],
            ]);

            return back()->with('message', 'Nama berhasil diperbarui');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi Kesalahan, Coba beberapa saat lagi');
        }
    }

    public function profile_change_password(Request $request)
    {
        $valid = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);

        if (Hash::check($valid['old_password'], Auth::user()->password)) {
            // Update password baru
            Auth::user()->update([
                'password' => Hash::make($valid['new_password']),
            ]);

            return back()->with('message', 'Password berhasil diperbarui');
        } else {
            // Jika password lama salah
            return back()->with('error', 'Password lama Anda salah');
        }
    }

    public function profile_change_rfid(Request $request)
    {
        $valid = $request->validate([
            'rfid' => 'required|string|max:255',  // Aturan validasi RFID
        ]);

        try {
            Auth::user()->update([
                'rfid' => $valid['rfid'],
            ]);

            return back()->with('message', 'RFID berhasil diperbarui');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi Kesalahan, Coba beberapa saat lagi');
        }
    }

      public function profile_change_photo(Request $request)
    {
        $fotoPath = null;

        // Memeriksa apakah ada file foto yang diupload
        if ($request->hasFile('foto')) {
            // Membuat nama file dengan timestamp
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            // Menyimpan foto ke direktori penyimpanan publik di folder 'izin'
            $fotoPath = $request->file('foto')->storeAs('profile', $fileName, 'public');

            // Log informasi bahwa foto berhasil disimpan
            Log::info('Foto berhasil disimpan:', ['path' => $fotoPath]);

            // Mengupdate URL foto di database
            Auth::user()->update([
                'photo_url' => asset('storage/' . 'profile/' . $fileName),
            ]);
        } else {
            // Jika tidak ada foto yang diterima
            Log::warning('Tidak ada foto yang diterima di request.');
        }

        // Mengarahkan kembali dengan pesan sesuai kondisi
        return back()->with('message', $fotoPath ? 'Foto profil berhasil diperbarui' : 'Tidak ada foto yang diterima.');
    }
}
