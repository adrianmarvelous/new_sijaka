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
        Schema::create('npp_npd_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('npp_npd')->constrained('npp_npd');
            $table->string('rekening')->nullable();
            $table->string('paket_pekerjaan')->nullable();
            $table->string('uraian')->nullable();
            $table->integer('anggaran')->nullable();
            $table->integer('pencairan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npp_npd_detail');
    }
};
