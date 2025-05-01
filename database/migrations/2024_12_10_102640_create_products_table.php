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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('image');
            $table->string('video')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('cost_price');
            $table->decimal('price');
            $table->decimal('discount')->nullable();
            $table->decimal('discounted_price')->nullable();
            $table->boolean('is_new')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stock')->default(true);
            $table->boolean('is_accept')->default(false);
            $table->boolean('is_return')->default(false);
            $table->string('code');
            $table->integer('stock');
            $table->string('status'); // saytda, bitib, olmayacaq
            $table->timestamps();
            $table->softDeletes();
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
