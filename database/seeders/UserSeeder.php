<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Pemilik Rosemary',
            'email' => 'pemilik@rosemary.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
        ]);

        User::create([
            'name' => 'Karyawan Satu',
            'email' => 'karyawan@rosemary.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);
    }
}
