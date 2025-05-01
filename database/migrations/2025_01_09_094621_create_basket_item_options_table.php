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
        Schema::create('basket_item_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('basket_item_id');
            $table->unsignedBigInteger('filter_id');
            $table->unsignedBigInteger('option_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_item_options');
    }
};
