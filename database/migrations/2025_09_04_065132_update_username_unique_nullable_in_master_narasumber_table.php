<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_narasumber', function (Blueprint $table) {
            // 🔹 Drop index unique lama kalau ada
            $table->dropUnique('master_narasumber_username_unique');

            // 🔹 Ubah kolom jadi nullable
            $table->string('username')->nullable()->change();

            // 🔹 Tambahkan unique lagi
            $table->unique('username', 'master_narasumber_username_unique');
        });
    }

    public function down(): void
    {
        Schema::table('master_narasumber', function (Blueprint $table) {
            $table->dropUnique('master_narasumber_username_unique');
            $table->string('username')->nullable(false)->change();
        });
    }
};
