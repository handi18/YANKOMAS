<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
        });

        // Data master langsung disuntik di sini pas tabel dibuat
        DB::table('layanan')->insert([
            ['nama_layanan' => 'Paspor Baru'],
            ['nama_layanan' => 'Paspor Penggantian'],
            ['nama_layanan' => 'Izin Tinggal'],
            ['nama_layanan' => 'BAP'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
