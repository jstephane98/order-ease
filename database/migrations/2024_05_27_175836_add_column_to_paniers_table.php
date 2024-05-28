<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('PANIERS', function (Blueprint $table) {
            $table->dropColumn('USR_NAME');
            $table->foreignId('user_id')->after("ART_CODE")->references('id')->on("WEB_USERS")->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('PANIERS', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
};
