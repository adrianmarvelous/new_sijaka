<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // 1. Update existing NULL data
        DB::table('master_pegawai')
            ->whereNull('created_at')
            ->update(['created_at' => now()]);

        DB::table('master_pegawai')
            ->whereNull('updated_at')
            ->update(['updated_at' => now()]);

        // 2. Enforce default & auto-update
        Schema::table('master_pegawai', function (Blueprint $table) {
            $table->timestamp('created_at')
                ->useCurrent()
                ->nullable(false)
                ->change();

            $table->timestamp('updated_at')
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->nullable(false)
                ->change();
        });
    }

    public function down()
    {
        Schema::table('master_pegawai', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
    }
};
