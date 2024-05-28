<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('PANIERS', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable();
//            $table->foreignId("order_id")->references('id')->on('ORDERS')->onDelete("set null");
        });
    }

    public function down(): void
    {
        Schema::table('PANIERS', function (Blueprint $table) {
            $table->dropForeign('order_id');
        });
    }
};
