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
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_condition_id')->constrained(table: 'patient_conditions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('type_id');
            $table->enum('type', ['medicine', 'session','activity']);
            $table->string('reel');
            $table->string('thumbnail');
            $table->boolean('is_watched')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->date('created_at_reel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
