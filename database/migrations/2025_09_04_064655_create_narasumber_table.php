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
        Schema::create('master_narasumber', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('nik')->nullable();
            $table->string('instansi')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('rekening')->nullable();
            $table->string('npwp_upload')->nullable();
            $table->string('ktp_upload')->nullable();
            $table->string('cv_upload')->nullable();
            $table->string('kak_upload')->nullable();
            $table->string('spesimen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_narasumber');
    }
};
