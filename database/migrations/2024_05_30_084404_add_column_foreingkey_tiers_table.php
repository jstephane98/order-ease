<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('TIERS', function (Blueprint $table) {
            /*$table->string('PCF_CODE');
            $table->string('PCF_TYPE');
            $table->string('PCF_RS');
            $table->string('PCF_RUE');
            $table->string('PCF_REG');
            $table->string('PCF_VILLE');
            $table->string('PAY_CODE');*/

            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references('id')->on("WEB_USERS")->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('TIERS', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
};
