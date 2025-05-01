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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kupon kodu
            $table->decimal('discount', 8, 2); // Endirim məbləği
            $table->enum('type', ['percentage', 'fixed']); // Endirim tipi (faiz ya məbləğ)
            $table->dateTime('valid_from'); // Başlama tarixi
            $table->dateTime('valid_until'); // Bitmə tarixi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
