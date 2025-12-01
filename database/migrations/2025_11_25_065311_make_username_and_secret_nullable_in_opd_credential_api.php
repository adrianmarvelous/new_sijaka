<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opd_credential_api', function (Blueprint $table) {
            $table->string('username')->nullable()->change();
            $table->string('secret')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('opd_credential_api', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
            $table->string('secret')->nullable(false)->change();
        });
    }
};
