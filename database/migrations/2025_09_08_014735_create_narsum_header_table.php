<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('narsum_daftar_hadir_header', function (Blueprint $table) {
            $table->id(); // Auto increment primary key
            $table->date('tanggal')->nullable();
            $table->integer('tanggal_surat_kesediaan')->nullable();
            $table->date('pukul_mulai')->nullable();
            $table->date('pukul_selesai')->nullable();
            $table->string('acara')->nullable();
            $table->string('tempat')->nullable();
            $table->string('masukan')->nullable();
            $table->integer('status')->nullable();
            $table->date('tgl_undangan')->nullable();
            $table->string('komponen')->nullable();
            $table->string('paket_pekerjaan_1')->nullable();
            $table->string('paket_pekerjaan_2')->nullable();
            $table->string('paket_pekerjaan_3')->nullable();
            $table->string('paket_pekerjaan_4')->nullable();
            $table->string('pptk')->nullable();
            $table->string('bidang')->nullable();
            $table->string('opd')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('narsum_daftar_hadir_header');
    }
};
