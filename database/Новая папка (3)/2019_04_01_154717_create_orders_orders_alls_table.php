<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersOrdersAllsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_orders_alls', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('ordersall_id')->unsigned();
            $table->primary(array('order_id', 'ordersall_id'));
            $table->timestamps();
        });

        Schema::table('orders_orders_alls', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('ordersall_id')->references('id')->on('orders_alls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_orders_alls');
    }
}
