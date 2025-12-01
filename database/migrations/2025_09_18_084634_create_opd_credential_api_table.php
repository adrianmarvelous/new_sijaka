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
        Schema::create('opd_credential_api', function (Blueprint $table) {
            $table->id();
            $table->string('opd_name');
            $table->string('api_name');
            $table->string('api_url');
            $table->string('username');
            $table->string('secret');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_credential_api');
    }
};
