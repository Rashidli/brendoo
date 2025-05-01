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
        Schema::create('advantage_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advantage_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();

            $table->unique(['advantage_id', 'locale']);
            $table->foreign('advantage_id')
                ->references('id')
                ->on('advantages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advantage_translations');
    }
};
