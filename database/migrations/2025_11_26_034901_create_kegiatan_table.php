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
        Schema::create('id_sub', function (Blueprint $table) {
            $table->id();
            $table->string('opd', 255);
            $table->string('bidang', 255);
            $table->string('kode_kegiatan', 255);
            $table->string('uraian_kegiatan', 255);
            $table->string('id_sub', 255);
            $table->string('kode_sub', 255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_sub');
    }
};
