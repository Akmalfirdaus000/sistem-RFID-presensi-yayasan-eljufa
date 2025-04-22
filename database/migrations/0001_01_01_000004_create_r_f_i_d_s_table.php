<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('rfids', function (Blueprint $table) {
            $table->string('id_rfid')->primary();
            $table->string('rfid')->unique();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('rfids');
    }
};
