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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained( 'users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('assistant_id')->nullable()->constrained( 'assistants')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_notifications')->default(true);
            $table->boolean('is_reminder')->default(false);
            $table->integer('reminder_medicine_time')->default(15);
            $table->enum('reminder_medicine_type', ['minute', 'day', 'hour'])->default('minute');
            $table->integer('reminder_session_time')->default(1);
            $table->enum('reminder_session_type', ['minute', 'day', 'hour'])->default('day');
            $table->integer('reminder_activity_time')->default(15);
            $table->enum('reminder_activity_type', ['minute', 'day', 'hour'])->default('minute');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
