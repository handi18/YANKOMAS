<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::truncate();
        
        $layanan = [
            'Paspor Baru',
            'Paspor Penggantian',
            'Izin Tinggal',
            'BAP',
        ];

        foreach ($layanan as $item) {
            Layanan::create([
                'nama_layanan' => $item,
            ]);
        }
    }
}
