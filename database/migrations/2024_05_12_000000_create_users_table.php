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
        Schema::create('WEB_USERS', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string("social_name")->nullable()->comment("Name of social connection (google, facebook or etc..)");
            $table->string("social_id")->nullable()->comment("Unique user ID in the social network");
            $table->mediumText("social_token")->nullable();
            $table->mediumText("social_refresh_token")->nullable();
            $table->enum("type", ["COMMERCIAL", "PARTENAIRE", "ADMIN"])->comment("Determine le type de compte !");

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
