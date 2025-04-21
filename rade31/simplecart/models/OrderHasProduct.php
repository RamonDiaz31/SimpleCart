<?php

namespace Rade31\SimpleCart\Models;

use Winter\Storm\Database\Pivot;

/**
 * Model
 */
class OrderHasProduct extends Pivot
{
    use \Winter\Storm\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'rade31_simple_cart_order_has_products';

    /**
     * @var array Validation rules
     */
    public $rules = [];


 
}
