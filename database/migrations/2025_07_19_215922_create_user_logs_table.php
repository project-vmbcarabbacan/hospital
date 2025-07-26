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
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['CREATED', 'UPDATED', 'LOGIN', 'LOGOUT', 'REFRESH', 'SESSION'])->nullable()->index();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id', 'user_logs_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logs');
    }
};
