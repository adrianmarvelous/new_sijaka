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
        Schema::create('npp_npd_temp', function (Blueprint $table) {
            $table->id();
            $table->string('id_sub')->nullable();
            $table->string('paket_pekerjaan')->nullable();
            $table->string('uraian')->nullable();
            $table->string('alokasi')->nullable();
            $table->string('rencana')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npp_npd_temp');
    }
};
