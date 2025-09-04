<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_narasumber', function (Blueprint $table) {
            // 🔹 Drop unique constraint pada username
            $table->dropUnique('master_narasumber_username_unique');

            // 🔹 Kalau mau nullable juga
            $table->string('username')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('master_narasumber', function (Blueprint $table) {
            // 🔹 Kembalikan lagi ke unique
            $table->string('username')->nullable(false)->change();
            $table->unique('username', 'master_narasumber_username_unique');
        });
    }
};
