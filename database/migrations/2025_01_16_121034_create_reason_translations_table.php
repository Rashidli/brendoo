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
        Schema::create('reason_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reason_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();

            $table->unique(['reason_id', 'locale']);
            $table->foreign('reason_id')
                ->references('id')
                ->on('reasons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_translations');
    }
};
