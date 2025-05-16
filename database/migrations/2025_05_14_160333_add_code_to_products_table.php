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
        // Create trigger for new products
        DB::unprepared('
            CREATE TRIGGER set_product_code BEFORE INSERT ON products
            FOR EACH ROW
            BEGIN
                IF NEW.code IS NULL THEN
                    SET @last_id = (SELECT COALESCE(MAX(id), 0) FROM products);
                    SET NEW.code = CONCAT("PRD-", LPAD(@last_id + 1, 6, "0"));
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS set_product_code');
    }
};
