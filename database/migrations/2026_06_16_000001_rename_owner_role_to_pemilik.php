<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('users')->where('role', 'owner')->update(['role' => 'pemilik']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'pemilik')->update(['role' => 'owner']);
    }
};
