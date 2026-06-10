<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Owner Rosemary',
            'email' => 'owner@rosemary.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Karyawan Satu',
            'email' => 'karyawan@rosemary.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);
    }
}
