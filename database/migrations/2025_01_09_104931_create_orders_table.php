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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['ordered', 'prepared','delivered_to_courier','delivered','cancelled'])
                ->default('ordered');
            $table->string('order_number')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->boolean('is_deliver')->default(false);
            $table->string('shop')->nullable();
            $table->enum('payment_type',['online','cash'])->default('cash');
            $table->decimal('total_price')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('delivered_price')->nullable();
            $table->decimal('final_price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
