<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('npp_npd_temp', function (Blueprint $table) {
            $table->string('opd', 150)->nullable()->after('id');
            $table->string('bidang', 150)->nullable()->after('opd');
        });
    }

    public function down()
    {
        Schema::table('npp_npd_temp', function (Blueprint $table) {
            $table->dropColumn(['opd', 'bidang']);
        });
    }
};
