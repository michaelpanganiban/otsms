<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->integer('item_id', true);
            $table->string('item_name', 100);
            $table->text('description')->nullable();
            $table->double('price');
            $table->integer('quantity');
            $table->string('status', 10)->default('Active');
            $table->bigInteger('created_by');
            $table->dateTime('created_at')->useCurrent();
            $table->bigInteger('modified_by')->nullable();
            $table->dateTime('modified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
