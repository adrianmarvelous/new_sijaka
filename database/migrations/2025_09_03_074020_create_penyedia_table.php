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
        Schema::create('master_penyedia', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)
            $table->string('username')->nullable();;
            $table->string('password')->nullable();;
            $table->string('nama')->nullable();;
            $table->string('direktur')->nullable();;
            $table->string('alamat')->nullable();;
            $table->string('telp')->nullable();;
            $table->string('rekening')->nullable();;
            $table->string('npwp')->nullable();;
            $table->string('npwp_upload')->nullable();;
            $table->string('pkp_upload')->nullable();;
            $table->string('ref_bank_upload')->nullable();;
            $table->string('siup_upload')->nullable();;
            $table->string('nib_upload')->nullable();;
            $table->string('spesimen')->nullable();;
            $table->string('stempel')->nullable();;
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_penyedia');
    }
};
