<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LayananSeeder::class,
            UserSeeder::class,
            AsirasiSeeder::class,
        ]);
    }
}
