<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Super Admin tunggal sebagai pintu masuk pertama
        User::updateOrCreate(
            ['username' => 'superadmin'], 
            [
                'nama' => 'Super Administrator',
                'nip' => '0000000001',
                'email' => 'superadmin@imigrasi.go.id',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
            ]
        );
    }
}