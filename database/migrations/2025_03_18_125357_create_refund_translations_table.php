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
        Schema::create('refund_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('description');

            $table->unique(['refund_id', 'locale']);
            $table->foreign('refund_id')->references('id')->on('refunds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_translations');
    }
};
