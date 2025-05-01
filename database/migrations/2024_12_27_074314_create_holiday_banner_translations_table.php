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
        Schema::create('holiday_banner_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('holiday_banner_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('value');
            $table->text('description');

            $table->unique(['holiday_banner_id', 'locale']);
            $table->foreign('holiday_banner_id')->references('id')->on('holiday_banners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_banner_translations');
    }
};
