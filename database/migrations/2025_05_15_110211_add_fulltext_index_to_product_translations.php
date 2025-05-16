<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('product_translations', function (Blueprint $table) {
            DB::statement('ALTER TABLE product_translations ADD FULLTEXT fulltext_title (title)');
        });
    }

    public function down()
    {
        Schema::table('product_translations', function (Blueprint $table) {
            DB::statement('ALTER TABLE product_translations DROP INDEX fulltext_title');
        });
    }

};
