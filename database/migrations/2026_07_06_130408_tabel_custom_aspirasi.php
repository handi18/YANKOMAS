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
        Schema::table('aspirasi', function (Blueprint $table) {
            // 1. Longgarkan foreign key layanan_id agar bisa di-set NULL saat memilih opsi kustom
            $table->foreignId('layanan_id')->nullable()->change();
            
            // 2. Tambahkan kolom pendamping untuk menampung input teks bebas
            $table->string('jenis_custom')->nullable()->after('jenis');
            $table->string('kategori_custom')->nullable()->after('kategori');
            $table->string('layanan_custom')->nullable()->after('layanan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            // Kembalikan ke kondisi semula jika di-rollback
            $table->foreignId('layanan_id')->nullable(false)->change();
            
            $table->dropColumn(['jenis_custom', 'kategori_custom', 'layanan_custom']);
        });
    }
};