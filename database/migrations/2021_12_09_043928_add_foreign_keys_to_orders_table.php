<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['modified_by'], 'fk_orders_modified_by')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'fk_orders_user_id')->references(['id'])->on('users');
            $table->foreign(['created_by'], 'fk_orders_created_by')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['product_id'], 'fk_orders_product_id')->references(['product_id'])->on('product_sales')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('fk_orders_modified_by');
            $table->dropForeign('fk_orders_user_id');
            $table->dropForeign('fk_orders_created_by');
            $table->dropForeign('fk_orders_product_id');
        });
    }
}
