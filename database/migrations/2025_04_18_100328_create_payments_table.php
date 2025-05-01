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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('operation_id')->unique(); // Tochka'dan gələn unikal ID
            $table->integer('amount'); // Ödəniş məbləği
            $table->string('status')->default('PENDING'); // pending, completed, failed
            $table->string('payment_method')->nullable(); // card, sbp, tinkoff etc.
            $table->string('purpose')->nullable(); // Ödənişin məqsədi
            $table->json('meta')->nullable(); // Əlavə məlumatlar
            $table->timestamps();

            // Index'lər
            $table->index('operation_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
