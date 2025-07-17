<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

public function login_action(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:2',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan',
            ])->onlyInput('email');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah',
            ])->onlyInput('password');
        }

        Auth::login($user, $request->has('remember_me'));
        $request->session()->regenerate();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('message', 'Login berhasil sebagai Admin');
            case 'kepala':
                return redirect()->route('kepala.dashboard')->with('message', 'Login berhasil sebagai Kepala');
            case 'user':
            default:
                return redirect()->route('user.dashboard')->with('message', 'Login berhasil');
        }
    }

    public function register_action(Request $request)
{
    $valid = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|string|email|max:150|unique:users,email',
        'password' => 'required|string|min:2|confirmed',
        'nik' => 'required|string|max:20',
        'jabatan' => 'required|string|max:50',
    ]);

    try {
        $user = User::create([
            'id' => Str::uuid(),
             'id_company' => $request->input('id_company', 'EL-00'), // Default ke "EL-00"
            'id_rfid' => $request->input('id_rfid'), 
            'name' => $valid['name'],
             'nik' => $valid['nik'],
            'jabatan' => $valid['jabatan'],
            'email' => $valid['email'],
            'password' => Hash::make($valid['password']),
        ]);

        Auth::loginUsingId($user->id);

        return redirect(route('user.dashboard'))->with('message', 'Register berhasil');
    } catch (\Throwable $th) {
        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
    }
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logout berhasil');
    }
}
