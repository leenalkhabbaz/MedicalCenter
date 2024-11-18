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
        Schema::create('assistants', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('image')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('language', ['en', 'ar'])->nullable()->default('ar');
            $table->string('fcm_token')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistants');
    }
};
