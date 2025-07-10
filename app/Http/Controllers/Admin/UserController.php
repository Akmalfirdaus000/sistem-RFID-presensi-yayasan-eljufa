<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function index()
{
    $users = User::all();
    $usedRfids = User::whereNotNull('id_rfid')->pluck('id_rfid')->toArray();
    $availableRfids = \App\Models\RFID::whereNotIn('id_rfid', $usedRfids)->get();

    return view('admin.users.index', compact('users', 'availableRfids'));
}
public function create()
{
    $usedRfids = User::whereNotNull('id_rfid')->pluck('id_rfid')->toArray();
    $availableRfids = \App\Models\RFID::whereNotIn('id_rfid', $usedRfids)->get();

    return view('admin.users.create', compact('availableRfids'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'nik' => 'nullable|string|max:16|unique:users,nik',
        'email' => 'required|string|email|max:255|unique:users,email',
        'jabatan' => 'nullable|string|max:255',
        'id_rfid' => 'nullable|exists:rfids,id_rfid',
        'role' => 'required|in:user,admin',
        'password' => 'required|string|min:2',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = new User();
    $user->id = Str::uuid();
    $user->id_company = auth()->user()->id_company;
    $user->name = $request->name;
    $user->nik = $request->nik;
    $user->email = $request->email;
    $user->jabatan = $request->jabatan;
    $user->id_rfid = $request->id_rfid;
    $user->role = $request->role;
    $user->password = bcrypt($request->password);

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('users', 'public');
        $user->photo = $photoPath;
    }

    $user->save();

    return redirect()->route('admin.users.index')->with('message', 'Pengguna berhasil ditambahkan.');
}


    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->update($request->only(['name', 'nik', 'email', 'jabatan', 'id_rfid', 'role']));
    return response()->json(['message' => 'User berhasil diperbarui']);
}


   public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['message' => 'User berhasil dihapus']);
}
public function show($id)
{
    $user = User::findOrFail($id);

    $presences = Attendance::with('user') // Pastikan relasi 'user' dimuat
        ->where('id_user', $id)
        ->orderBy('tanggal', 'desc')
        ->get()
        ->groupBy(function($record) {
            return \Carbon\Carbon::parse($record->tanggal)->format('Y-m');
        });

    $rekapPresensi = [];
    foreach ($presences as $month => $records) {
        $rekapPresensi[$month] = [
            'hadir' => $records->where('status', 'hadir')->count(),
            'cuti' => $records->where('status', 'cuti')->count(),
            'izin' => $records->where('status', 'izin')->count(),
            'absen' => $records->where('status', 'absen')->count(),
        ];
    }

    return view('admin.users.show', compact('user', 'presences', 'rekapPresensi'));
}




}
