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
        Schema::create('contact_item_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_item_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('value');

            $table->unique(['contact_item_id', 'locale']);
            $table->foreign('contact_item_id')->references('id')->on('contact_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_item_translations');
    }
};
