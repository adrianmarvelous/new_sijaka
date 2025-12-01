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
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            // ubah kolom acara ke TEXT
            $table->text('acara')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            // balik lagi ke VARCHAR(255) default kalau perlu
            $table->string('acara', 255)->change();
        });
    }
};
