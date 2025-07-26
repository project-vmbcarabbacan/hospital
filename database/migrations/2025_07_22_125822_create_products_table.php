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
            $table->string('sku', 50)->index();
            $table->string('name')->index();
            $table->decimal('price', 10, 2);
            $table->bigInteger('stocks')->default(0);
            $table->string('photo')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['distributor_id', 'brand_id'], 'product_dist_brand');
            $table->index(['distributor_id', 'brand_id', 'sku'], 'dist_brand_sku');
            $table->index(['distributor_id', 'sku'], 'dist_sku');
            $table->index(['brand_id', 'sku'], 'brand_sku');
            $table->index(['distributor_id', 'brand_id', 'name'], 'dist_brand_name');
            $table->index(['distributor_id', 'name'], 'dist_name');
            $table->index(['brand_id', 'name'], 'brand_name');
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
