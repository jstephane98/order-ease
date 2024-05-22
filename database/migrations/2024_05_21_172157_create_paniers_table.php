<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('PANIERS', function (Blueprint $table) {
            $table->string('ART_CODE', 100);
//            $table->foreign('ART_CODE')->on('ARTICLES')->references('ART_CODE')->onDelete('CASCADE');
            $table->string('USR_NAME', 100);
//            $table->foreign('USR_NAME')->on('USERS')->references('USR_NAME')->onDelete('CASCADE');
            $table->integer('QUANTITY');
            $table->boolean('STATUS')->default(FALSE);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PANIERS');
    }
};
