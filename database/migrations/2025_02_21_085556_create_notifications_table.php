<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('notifications', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('id_user'); // Pastikan tipe datanya sama dengan users.id
    $table->text('message');
    $table->boolean('is_read')->default(false);
    $table->timestamps();

    // Foreign key harus cocok dengan users.id (bukan id_user)
    $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
