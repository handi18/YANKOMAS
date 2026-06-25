<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin
        User::create([
            'nama' => 'Administrator',
            'nip' => '19800101001',
            'username' => 'admin',
            'email' => 'admin@imigrasi.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // create admin khusus - Handi
        User::create([
            'nama' => 'Administrator2',
            'nip' => '123140012',
            'username' => 'handi_admin',
            'email' => 'admin2@imigrasi.go.id',
            'password' => Hash::make('0987184H'),
            'role' => 'admin',
        ]);

        // Create dummy petugas
        $petugas = [
            [
                'nama' => 'Budi Santoso',
                'nip' => '19850315002',
                'username' => 'budi.santoso',
                'email' => 'budi.santoso@imigrasi.go.id',
                'role' => 'petugas',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'nip' => '19880620003',
                'username' => 'siti.nurhaliza',
                'email' => 'siti.nurhaliza@imigrasi.go.id',
                'role' => 'petugas',
            ],
            [
                'nama' => 'Ahmad Wijaya',
                'nip' => '19900812004',
                'username' => 'ahmad.wijaya',
                'email' => 'ahmad.wijaya@imigrasi.go.id',
                'role' => 'petugas',
            ],
            [
                'nama' => 'Rini Kusuma',
                'nip' => '19920503005',
                'username' => 'rini.kusuma',
                'email' => 'rini.kusuma@imigrasi.go.id',
                'role' => 'petugas',
            ],
            [
                'nama' => 'Eka Prasetya',
                'nip' => '19950711006',
                'username' => 'eka.prasetya',
                'email' => 'eka.prasetya@imigrasi.go.id',
                'role' => 'petugas',
            ],
        ];

        foreach ($petugas as $item) {
            User::create([
                'nama' => $item['nama'],
                'nip' => $item['nip'],
                'username' => $item['username'],
                'email' => $item['email'],
                'password' => Hash::make('password'),
                'role' => $item['role'],
            ]);
        }

        // Create additional dummy petugas using factory
        User::factory()
            ->petugas()
            ->count(10)
            ->create();
    }
}
