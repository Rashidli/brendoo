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
        Schema::create('product_main_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_main_id');
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['product_main_id', 'locale']);
            $table->foreign('product_main_id')->references('id')->on('product_mains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_main_translations');
    }
};
