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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->index();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'day_of_week'], 'user_day_week');
            $table->index(['user_id', 'start_time'], 'user_start');
            $table->index(['user_id', 'day_of_week', 'start_time', 'is_active'], 'user_day_start_act');
            $table->index(['user_id', 'day_of_week', 'end_time', 'is_active'], 'user_day_end_act');
            $table->index(['user_id', 'day_of_week', 'start_time', 'end_time', 'is_active'], 'user_day_start_end_act');
            $table->index(['user_id', 'day_of_week', 'is_active'], 'user_day_act');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
