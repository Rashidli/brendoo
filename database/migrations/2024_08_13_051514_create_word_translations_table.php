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
        Schema::create('word_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->timestamps();

            $table->unique(['word_id', 'locale']);
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_translations');
    }
};
