<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orderan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restoran_id')->constrained('restoran')->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('user')->cascadeOnDelete();
            $table->date('tanggal_orderan');
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orderan');
    }
};
