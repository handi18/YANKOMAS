<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mengubah ENUM secara langsung via raw SQL
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE aspirasi CHANGE COLUMN media media ENUM('Tatap Muka', 'Telepon', 'WhatsApp', 'Web/Online') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ke ENUM awal (Mungkin akan error jika ada data Web/Online, tapi biarkan saja untuk fallback)
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE aspirasi CHANGE COLUMN media media ENUM('Tatap Muka', 'Telepon', 'WhatsApp') NOT NULL");
    }
};
