<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['0', '1']);
            $table->text('text');
            $table->date('date')->nullable();
            $table->timestamps();
            $table->integer('orders_product_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
        });
        Schema::table('orders', function (Blueprint $table) {
        $table->foreign('orders_product_id')->references('id')->on('orders_products');
        $table->foreign('user_id')->references('id')->on('users');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
