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
        Schema::create('instagram_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instagram_id');
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['instagram_id', 'locale']);
            $table->foreign('instagram_id')->references('id')->on('instagrams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_translations');
    }
};
