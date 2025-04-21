<?php

namespace Rade31\SimpleCart\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class CreateTableProducts extends Migration
{
    public function up()
    {
        Schema::create('rade31_simple_cart_products', function ($table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->unsignedDecimal('purchase_price', 7, 2);
            $table->unsignedDecimal('unit_price', 7, 2,);
            $table->string('barcode')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('rade31_simple_cart_products');
    }
}
