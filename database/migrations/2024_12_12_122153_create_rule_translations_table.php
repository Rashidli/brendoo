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
        Schema::create('rule_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('description');

            $table->unique(['rule_id', 'locale']);
            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_translations');
    }
};
