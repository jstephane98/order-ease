<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('WEB_USERS', function (Blueprint $table) {

            $table->string("TIER_CODE")->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('WEB_USERS', function (Blueprint $table) {
            $table->dropColumn('TIER_CODE');
        });
    }
};