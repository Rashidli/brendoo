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
        Schema::create('login_banner_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('login_banner_id');
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['login_banner_id', 'locale']);
            $table->foreign('login_banner_id')->references('id')->on('login_banners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_banner_translations');
    }
};
