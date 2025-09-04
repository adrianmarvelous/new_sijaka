<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_pegawai', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('master_pegawai', function (Blueprint $table) {
            $table->string('jabatan')->nullable(false)->change();
        });
    }
};

