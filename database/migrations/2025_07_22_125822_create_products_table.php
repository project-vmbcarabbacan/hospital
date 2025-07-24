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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained('distributors')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('sku', 50);
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->bigInteger('stocks')->default(0);
            $table->string('photo')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['distributor_id', 'brand_id'], 'product_dist_brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
