<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('id');
            $table->string('nip')->nullable()->unique()->after('username');
            $table->string('nik')->nullable()->unique()->after('nip');
            $table->string('user_type')->default('pegawai')->after('nik'); // e.g. 'pegawai', 'admin'
            $table->unsignedBigInteger('id_pegawai')->nullable()->after('user_type');

            // optional: add foreign key if master_pegawai exists
            $table->foreign('id_pegawai')->references('id')->on('master_pegawai')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_pegawai']);
            $table->dropColumn(['username', 'nip', 'nik', 'user_type', 'id_pegawai']);
        });
    }
};
