<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ORDERS', function (Blueprint $table) {
            $table->id();
            $table->integer('NBR_ART')->comment("Nombre d'article");
            $table->enum("status", ["INCOMPLETE", "COMPLETE"]);
            $table->integer("price");
            $table->foreignId('user_id')->references('id')->on('WEB_USERS')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
