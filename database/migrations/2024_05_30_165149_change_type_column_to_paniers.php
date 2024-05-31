<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('PANIERS', function (Blueprint $table) {
            $table->integer("STATUS")->change();
        });
    }

    public function down(): void
    {
        Schema::table('PANIERS', function (Blueprint $table) {
            //
        });
    }
};
