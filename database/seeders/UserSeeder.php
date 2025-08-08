<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Buat akun owner
        User::create([
            'name' => 'Owner Utama',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'), // ganti dengan yang aman di produksi
            'role' => 'owner',
        ]);

        // Buat akun admin
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // ganti dengan yang aman di produksi
            'role' => 'admin',
        ]);
    }
    
}
