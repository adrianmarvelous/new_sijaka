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
        Schema::create('narsum_daftar_hadir_umum', function (Blueprint $table) {
            $table->id();
            $table->integer('id_header')->nullable();
            $table->string('nik')->nullable();
            $table->integer('status')->default(0);
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('narsum_daftar_hadir_umum');
    }
};
