<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBatchUuidColumnToActivityLogTable extends Migration
{
    public function up()
    {
        if(!Schema::hasTable(config('activitylog.table_name'))) {
            Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
                $table->uuid('batch_uuid')->nullable()->after('properties');
            });   return;
        }
    }

    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->dropColumn('batch_uuid');
        });
    }
}
