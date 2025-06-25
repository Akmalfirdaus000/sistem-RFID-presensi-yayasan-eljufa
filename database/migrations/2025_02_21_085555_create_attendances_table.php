<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('attendances', function (Blueprint $table) {
    $table->uuid('id_attendance')->primary(); // Ubah ke UUID agar seragam
    $table->uuid('id_user'); // Pastikan sesuai dengan primary key di users
    $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); // Sesuaikan dengan users.id
    $table->text('keterangan')->nullable();
    $table->string('lampiran')->nullable();
    $table->string('foto')->nullable();
    $table->date('tanggal');
    $table->time('jam_masuk')->nullable();
    $table->time('jam_keluar')->nullable();
    $table->enum('status', ['hadir', 'alpa', 'izin','sakit','lainya'])->default('alpa');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
