<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('WEB_USERS', function (Blueprint $table) {
            $table->string("created_at")->change();
            $table->string("updated_at")->change();
        });
    }

    public function down(): void
    {
        Schema::table('WEB_USERS', function (Blueprint $table) {
            //
        });
    }
};
