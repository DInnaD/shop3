<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAordersBordersallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aorders_bordersalls', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('ordersAll_id')->unsigned();
            $table->primary(array('order_id', 'ordersAll_id'));
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('ordersAll_id')->references('id')->on('orders_alls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
