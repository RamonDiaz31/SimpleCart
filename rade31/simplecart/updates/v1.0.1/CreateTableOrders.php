<?php

namespace Rade31\SimpleCart\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class CreateTableOrders extends Migration
{
    public function up()
    {
        Schema::create('rade31_simple_cart_orders', function ($table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedDecimal('total', 7, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('rade31_simple_cart_orders');
    }
}
