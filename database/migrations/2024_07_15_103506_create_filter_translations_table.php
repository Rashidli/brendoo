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
        Schema::create('filter_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filter_id');
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['filter_id', 'locale']);
            $table->foreign('filter_id')->references('id')->on('filters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_translations');
    }
};
