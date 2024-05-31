<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ORDERS', function (Blueprint $table) {
            $table->string("PCF_CODE")->after("user_id")->nullable();
//            $table->foreign('PCF_CODE')->references("PCF_CODE")->on("TIERS")->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ORDERS', function (Blueprint $table) {
            $table->dropForeign("PCF_CODE");
        });
    }
};
