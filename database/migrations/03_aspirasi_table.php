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
            $table->string('nama_pengadu');
            $table->string('no_telp')->nullable(); 
            $table->date('tanggal_kejadian');
            $table->time('jam_kejadian');
            $table->enum('jenis', ['saran', 'informasi', 'pengaduan']); 
            $table->string('jenis_custom')->nullable();
            $table->enum('kategori', ['ringan', 'sedang', 'berat'])->nullable(); 
            $table->string('kategori_custom')->nullable();
            $table->foreignId('layanan_id')->nullable()->constrained('layanan')->onDelete('cascade');
            $table->string('layanan_custom')->nullable();
            $table->enum('media', ['Tatap Muka', 'Telepon', 'WhatsApp', 'Web/Online']);
            $table->text('isi_aspirasi');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('status', ['Baru', 'Diproses', 'Selesai'])->default('Baru');
            $table->text('jawaban')->nullable();
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
