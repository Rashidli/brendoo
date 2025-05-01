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
        Schema::create('top_line_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('top_line_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();

            $table->unique(['top_line_id', 'locale']);
            $table->foreign('top_line_id')
                ->references('id')
                ->on('top_lines')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_line_translations');
    }
};
