<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket')->unique();
            $table->date('tanggal_kejadian');
            $table->time('jam_kejadian');
            $table->enum('jenis', ['saran', 'masukan', 'pengaduan']);
            $table->enum('kategori', ['ringan', 'sedang', 'berat']);
            $table->text('isi_aspirasi');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->enum('media', ['Tatap Muka', 'Telepon', 'WhatsApp']);
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['Baru', 'Diproses', 'Selesai'])->default('Baru');
            $table->timestamps();
            
            $table->index('tanggal_kejadian');
            $table->index('status');
            $table->index('jenis');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};
