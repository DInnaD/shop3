<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersAllsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_alls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('number')->nullable;
            $table->integer('qty')->nullable;
            $table->integer('qty_m')->nullable;
            $table->float('sum')->default(0);
            $table->date('date')->nullable();
            $table->timestamps();
        });

        Schema::table('orders_alls', function (Blueprint $table) {
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
        Schema::dropIfExists('orders_alls');
    }
}
