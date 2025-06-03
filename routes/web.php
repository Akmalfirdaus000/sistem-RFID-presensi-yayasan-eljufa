<?php

// use App\Http\Controllers\Admin\PresensiController as AdminPresensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\UserUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\AdminPresensiController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\AdminRfidController;
use App\Http\Controllers\Admin\AdminPresensiController;
use App\Http\Controllers\Admin\AdminRekapController;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function (){
    Route::get('login', 'login')->name('login');
    Route::post('login/action', 'login_action')->name('login.action');

    Route::get('register', 'register')->name('register');
    Route::post('register/action', 'register_action')->name('register.action');

    Route::get('logout', 'logout')->name('logout');
});
Route::middleware(['auth', 'user'])->prefix('user')->group(function (){

    Route::controller(DashboardController::class)->group(function(){
        Route::get('dashboard', 'user_dashboard')->name('user.dashboard');
    });
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::get('/presensi/data', [PresensiController::class, 'getPresensiData'])->name('presensi.data');
    Route::post('/presensi/izin', [AttendanceController::class, 'ajukanIzin'])->name('presensi.izin');

    Route::get('/riwayat', [PresensiController::class, 'getRiwayatUser'])->name('riwayat.index');
    Route::get('/riwayat/{id}/detail', [PresensiController::class, 'getDetailPresensi']);


});
Route::middleware('auth')->controller(UserUserController::class)->prefix('u')->group(function() {
    Route::get('profile', 'profile')->name('profile');

    Route::post('profile-change-name', 'profile_change_name')->name('profile.change.name');
    Route::post('profile-change-password', 'profile_change_password')->name('profile.change.password');
    Route::post('profile-change-rfid', 'profile_change_rfid')->name('profile.change.rfid');

    // Menambahkan route untuk mengubah foto profil
    Route::post('profile-change-photo', 'profile_change_photo')->name('profile.change.photo');
});



// Route Untuk Pengguna dengan Role 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'admin_dashboard')->name('admin.dashboard');
    });

    // Rute untuk manajemen pengguna (tanpa resource)
    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('admin.users.index'); // Menampilkan daftar pengguna
        Route::get('users/create', 'create')->name('admin.users.create'); // Form tambah pengguna
        Route::post('users/store', 'store')->name('admin.users.store'); // Menyimpan pengguna baru
        Route::get('users/{user}', 'show')->name('admin.users.show'); // Detail pengguna
        Route::get('users/{user}/edit', 'edit')->name('admin.users.edit'); // Form edit pengguna
        Route::put('users/{user}', 'update')->name('admin.users.update'); // Update pengguna
        Route::delete('users/{id}', 'destroy')->name('admin.users.destroy'); // Hapus pengguna
    });
    Route::controller(AdminPresensiController::class)->group(function () {
        Route::get('/presensi', 'index')->name('admin.presensi.index');
        Route::get('/presensi/{id_user}', 'show')->name('admin.presensi.show'); // Tambah route untuk detail presensi
    });
    Route::get('/riwayat', [AdminPresensiController::class, 'riwayat'])->name('admin.riwayat.index');
    Route::get('/rfid', [AdminRfidController::class, 'index'])->name('admin.rfid.index');
    // Route::put('/rfid', [AdminRfidController::class, 'index'])->name('admin.rfid.update');
    Route::get('/admin/rfid', [AdminRfidController::class, 'index'])->name('admin.rfid.index');
    Route::get('/admin/rfid', [AdminRfidController::class, 'create'])->name('admin.rfid.add');
    // Menyimpan RFID baru
    Route::post('/admin/rfid', [AdminRfidController::class, 'store'])->name('admin.rfid.store');

    // Form edit RFID
    Route::get('/admin/rfid/{id}/edit', [AdminRfidController::class, 'edit'])->name('admin.rfid.edit');

    // Update RFID
    Route::put('/admin/rfid/{id}', [AdminRfidController::class, 'update'])->name('admin.rfid.update');

    // Hapus RFID
    Route::delete('/admin/rfid/{id}', [AdminRfidController::class, 'destroy'])->name('admin.rfid.destroy');
    Route::get('/admin/rekap', [AdminRekapController::class, 'index'])->name('admin.rekap.index');




});

