<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMeasurementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measurement', function (Blueprint $table) {
            $table->foreign(['custom_id'], 'pk_custom_measurement')->references(['custom_id'])->on('customization');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measurement', function (Blueprint $table) {
            $table->dropForeign('pk_custom_measurement');
        });
    }
}
