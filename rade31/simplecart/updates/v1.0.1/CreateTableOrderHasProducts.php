<?php

namespace Rade31\SimpleCart\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class CreateTableOrderHasProducts extends Migration
{
    public function up()
    {
        Schema::create('rade31_simple_cart_order_has_products', function ($table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->unsignedDecimal('price', 7, 2);
            $table->unsignedDecimal('subtotal', 9, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('rade31_simple_cart_order_has_products');
    }
}
