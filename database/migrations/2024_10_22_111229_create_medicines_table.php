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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_condition_id')->constrained(table: 'patient_conditions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('description');
            $table->integer('pills_per_dose');
            $table->datetime('first_dose');
            $table->integer('frequent');
            $table->enum('action_date_type', ['hour', 'day', 'month','week']);
            $table->date('end_date')->nullable();
            $table->boolean('is_continuous')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
