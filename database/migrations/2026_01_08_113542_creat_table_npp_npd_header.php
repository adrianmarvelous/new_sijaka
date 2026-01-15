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
        Schema::create('npp_npd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_id_sub')->constrained('id_sub');
            $table->integer('nomer');
            $table->enum('panjar_ls_kkpd', ['PANJAR', 'LS','KKPD']);
            $table->string('sumber_dana')->nullable();
            $table->string('nama_pptk')->nullable();
            $table->string('nip_pptk')->nullable();
            $table->string('pangkat_pptk')->nullable();
            $table->string('nama_bendahara')->nullable();
            $table->string('nip_bendahara')->nullable();
            $table->string('pangkat_bendahara')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('alasan')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npp_npd');
    }
};
