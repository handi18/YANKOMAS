<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            echo "UserSeeder tidak dapat dijalankan di environment production.\n";
            return;
        }

        $defaultPassword = Hash::make('password123'); 

        // 1. Akun Admin Utama (Gunakan updateOrCreate agar jika sudah ada, tidak double)
        User::updateOrCreate(
            ['username' => 'admin'], // Kunci pengecekan berdasarkan username
            [
                'nama' => 'Administrator Utama',
                'nip' => '19800101001',
                'email' => 'admin@imigrasi.go.id',
                'password' => $defaultPassword,
                'role' => 'admin',
            ]
        );

        // 2. Daftar Petugas Baru yang mau dimasukkan
        $daftarPetugas = [
            [
                'nama' => 'Handi (Petugas)',
                'nip' => '123140012',
                'username' => 'handi_petugas',
                'email' => 'handi@imigrasi.go.id',
                'role' => 'petugas',
                'password' => $defaultPassword,
            ],
            [
                'nama' => 'Doni (Petugas)',
                'nip' => '123140013',
                'username' => 'doni_petugas',
                'email' => 'doni@imigrasi.go.id',
                'role' => 'petugas',
                'password' => $defaultPassword,
            ],
            [
                'nama' => 'Okta (Petugas)',
                'nip' => '123140014',
                'username' => 'okta_petugas',
                'email' => 'okta@imigrasi.go.id',
                'role' => 'petugas',
                'password' => $defaultPassword,
            ],
        ];

        // Loop untuk memasukkan petugas secara aman tanpa duplikasi username
        foreach ($daftarPetugas as $petugas) {
            User::updateOrCreate(
                ['username' => $petugas['username']], 
                $petugas
            );
        }
    }
}