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
        Schema::create('master_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('opd'); // VARCHAR
            $table->string('kategori'); // VARCHAR
            $table->string('nama'); // VARCHAR
            $table->string('nik'); // VARCHAR
            $table->string('nip'); // VARCHAR
            $table->string('unit_kerja'); // VARCHAR
            $table->string('jabatan'); // VARCHAR
            $table->string('jenis_kelamin'); // VARCHAR
            $table->date('tgl_lahir'); // VARCHAR
            $table->string('tk_pendidikan'); // VARCHAR
            $table->string('golongan'); // VARCHAR
            $table->string('eselon'); // VARCHAR
            $table->string('jenisjabatan'); // VARCHAR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pegawai');
    }
};
