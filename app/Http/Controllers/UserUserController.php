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
    Log::info('Masuk ke method profile_change_photo');

    $fotoPath = null;
    $user = Auth::user();

    Log::info('User login:', ['id' => $user?->id, 'email' => $user?->email]);

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Simpan di folder storage/app/public/profile
        $fotoPath = $file->storeAs('profile', $fileName, 'public');

        Log::info('Foto berhasil disimpan:', ['path' => $fotoPath]);

        // Simpan path ke kolom 'photo' (bukan photo_url!)
        $success = $user->update([
            'photo' => 'storage/' . $fotoPath, // ← gunakan kolom photo
        ]);

        Log::info('Hasil update kolom photo:', ['success' => $success]);

        return back()->with('message', 'Foto profil berhasil diperbarui');
    } else {
        Log::warning('Tidak ada foto yang diterima.');
        return back()->with('error', 'Tidak ada foto yang dikirimkan.');
    }
}
}
