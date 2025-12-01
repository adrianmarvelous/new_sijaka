<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            // ubah kolom menjadi integer & bisa null
            $table->integer('tanggal_surat_kesediaan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            // kembalikan lagi ke tipe date kalau rollback
            $table->date('tanggal_surat_kesediaan')->nullable()->change();
        });
    }
};
