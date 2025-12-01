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
        Schema::create('narsum_daftar_hadir_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_header')->nullable();
            $table->unsignedBigInteger('id_narsum')->nullable();
            $table->text('masukan')->nullable();
            $table->string('no_surat', 100)->nullable();
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->string('ttd_narsum')->nullable();
            $table->string('bendahara')->nullable();
            $table->string('pptk')->nullable();
            $table->timestamps();

            // (Optional) if you have foreign keys:
            // $table->foreign('id_header')->references('id')->on('narsum_daftar_hadir_header')->onDelete('cascade');
            // $table->foreign('id_narsum')->references('id')->on('narsum')->onDelete('set null');
            // $table->foreign('id_transaksi')->references('id')->on('transaksi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('narsum_daftar_hadir_content');
    }
};
