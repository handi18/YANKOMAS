<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            $table->unsignedBigInteger('petugas_id')->nullable()->change();
            // Mengubah tipe kolom media menjadi string untuk fleksibilitas karena alter ENUM sering gagal di beberapa versi DB
            $table->string('media')->default('Web/Online')->change();
        });
    }

    public function down(): void
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            $table->unsignedBigInteger('petugas_id')->nullable(false)->change();
            // Rollback ke ENUM
            // Note: Data dengan 'Web/Online' mungkin menyebabkan warning/error saat diubah kembali ke ENUM jika tidak dihandle
            $table->enum('media', ['Tatap Muka', 'Telepon', 'WhatsApp'])->change();
        });
    }
};
