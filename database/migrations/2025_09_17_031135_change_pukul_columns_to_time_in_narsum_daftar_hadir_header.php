<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            $table->time('pukul_mulai')->nullable()->change();
            $table->time('pukul_selesai')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            $table->dateTime('pukul_mulai')->nullable()->change();
            $table->dateTime('pukul_selesai')->nullable()->change();
        });
    }
};

