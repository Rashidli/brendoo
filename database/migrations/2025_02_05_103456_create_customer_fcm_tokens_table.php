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
        Schema::create('customer_fcm_tokens', function (Blueprint $table) {
            $table->id();
            $table->text('bearer')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('fcm_token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_fcm_tokens');
    }
};
