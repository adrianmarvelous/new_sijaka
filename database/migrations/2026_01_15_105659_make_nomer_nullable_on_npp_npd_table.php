<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('npp_npd', function (Blueprint $table) {
            $table->string('nomer')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('npp_npd', function (Blueprint $table) {
            $table->string('nomer')->nullable(false)->change();
        });
    }
};
