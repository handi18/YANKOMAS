<?php

namespace Database\Factories;

use App\Models\Aspirasi;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AspirasiFactory extends Factory
{
    protected $model = Aspirasi::class;

    public function definition(): array
{
    $jenis = $this->faker->randomElement(['saran', 'informasi', 'pengaduan']);

    return [
        'nomor_tiket'      => 'ASP-' . now()->format('Ymd') . '-' . str_pad($this->faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
        'tanggal_kejadian' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
        'jam_kejadian'     => $this->faker->time('H:i:s'),
        'jenis'            => $jenis,
        'kategori'         => $jenis === 'pengaduan'
                                ? $this->faker->randomElement(['ringan', 'sedang', 'berat'])
                                : null,
        'isi_aspirasi'     => $this->faker->paragraph(5),
        'layanan_id'       => Layanan::inRandomOrder()->first()?->id ?? 1,
        'media'            => $this->faker->randomElement(['Tatap Muka', 'Telepon', 'WhatsApp']),
        'petugas_id'       => User::where('role', 'petugas')->inRandomOrder()->first()?->id ?? 1,
        'status'           => $this->faker->randomElement(['Baru', 'Diproses', 'Selesai']),
    ];
}
}
