<?php

namespace Database\Seeders;

use App\Models\Aspirasi;
use Illuminate\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        // Create 50 dummy aspirasi
        Aspirasi::factory()
            ->count(50)
            ->create();
    }
}
