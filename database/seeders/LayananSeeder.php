<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = [
            'Paspor Baru',
            'Paspor Penggantian',
            'Izin Tinggal',
            'WNA',
            'Informasi',
        ];

        foreach ($layanan as $item) {
            Layanan::create([
                'nama_layanan' => $item,
            ]);
        }
    }
}
