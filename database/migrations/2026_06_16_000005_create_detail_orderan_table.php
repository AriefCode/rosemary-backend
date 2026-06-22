<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_orderan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderan_id')->constrained('orderan')->cascadeOnDelete();
            $table->foreignId('sayur_id')->constrained('sayur')->cascadeOnDelete();
            $table->decimal('jumlah', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_orderan');
    }
};
