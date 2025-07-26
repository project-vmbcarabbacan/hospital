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
        Schema::create('schedule_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date')->index();
            $table->time('start_time')->index();
            $table->time('end_time');
            $table->string('location');
            $table->unsignedBigInteger('source_schedule_id')->nullable();
            $table->enum('status', ['available', 'booked', 'cancelled'])->index();
            $table->string('google_event_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_instances');
    }
};
