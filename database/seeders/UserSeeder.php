<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Cegah seeder dijalankan di environment production untuk keamanan data
        if (app()->environment('production')) {
            echo "UserSeeder tidak dapat dijalankan di environment production.\n";
            return;
        }

        // 1. Definisikan password default sekali saja untuk menghemat proses hashing di loop
        $defaultPassword = Hash::make('password123'); 

        // 2. Gabungkan akun inti menggunakan insert massal (Hemat query)
        User::insert([
            [
                'nama' => 'Administrator',
                'nip' => '19800101001',
                'username' => 'admin',
                'email' => 'admin@imigrasi.go.id',
                'password' => $defaultPassword,
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Administrator2 (Handi)',
                'nip' => '123140012',
                'username' => 'handi_admin',
                'email' => 'admin2@imigrasi.go.id',
                'password' => $defaultPassword, // Jangan taruh password asli di sini!
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Data dummy petugas spesifik
        $petugas = [
            ['nama' => 'Budi Santoso', 'nip' => '19850315002', 'username' => 'budi.santoso', 'email' => 'budi.santoso@imigrasi.go.id', 'role' => 'petugas', 'password' => $defaultPassword, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Siti Nurhaliza', 'nip' => '19880620003', 'username' => 'siti.nurhaliza', 'email' => 'siti.nurhaliza@imigrasi.go.id', 'role' => 'petugas', 'password' => $defaultPassword, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Ahmad Wijaya', 'nip' => '19900812004', 'username' => 'ahmad.wijaya', 'email' => 'ahmad.wijaya@imigrasi.go.id', 'role' => 'petugas', 'password' => $defaultPassword, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Rini Kusuma', 'nip' => '19920503005', 'username' => 'rini.kusuma', 'email' => 'rini.kusuma@imigrasi.go.id', 'role' => 'petugas', 'password' => $defaultPassword, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Eka Prasetya', 'nip' => '19950711006', 'username' => 'eka.prasetya', 'email' => 'eka.prasetya@imigrasi.go.id', 'role' => 'petugas', 'password' => $defaultPassword, 'created_at' => now(), 'updated_at' => now()],
        ];

        User::insert($petugas);

        // 4. Tambahan data dummy otomatis via factory
        User::factory()->petugas()->count(10)->create();
    }
}