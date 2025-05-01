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
        Schema::create('single_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('single_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('slug')->unique();

            $table->unique(['single_id', 'locale']);
            $table->foreign('single_id')->references('id')->on('singles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('single_translations');
    }
};
