<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sayur', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('satuan');
            $table->decimal('jumlah_persediaan', 10, 2)->default(0);
            $table->date('tanggal_masuk')->nullable();
            $table->unsignedInteger('estimasi_ketahanan')->nullable();
            $table->decimal('batas_minimum', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sayur');
    }
};
