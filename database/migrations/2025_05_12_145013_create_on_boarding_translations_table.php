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
        Schema::create('on_boarding_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('on_boarding_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('sub_title');

            $table->unique(['on_boarding_id', 'locale']);
            $table->foreign('on_boarding_id')->references('id')->on('on_boardings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('on_boarding_translations');
    }
};
