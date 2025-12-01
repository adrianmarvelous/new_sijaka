<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            $table->longText('masukan')->change();
        });
    }

    public function down()
    {
        Schema::table('narsum_daftar_hadir_header', function (Blueprint $table) {
            $table->string('masukan', 255)->change(); // rollback
        });
    }
};

