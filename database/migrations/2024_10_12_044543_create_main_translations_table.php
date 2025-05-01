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
        Schema::create('main_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['main_id', 'locale']);
            $table->foreign('main_id')->references('id')->on('mains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_translations');
    }
};
