<?php

namespace Rade31\SimpleCart\Models;

use Model;
use Winter\Storm\Database\Relations\HasOne;

/**
 * Model
 */
class Product extends Model
{
    use \Winter\Storm\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'rade31_simple_cart_products';

    /**
     * @var array Validation rules
     */
    public $rules = [];


    

    public function type(): HasOne
    {
        return $this->hasOne(ProductType::class, 'id', 'product_type_id');

    }



    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'rade31_simple_cart_order_has_products', 'product_id', 'order_id')->using(OrderHasProduct::class)->withPivot('quantity', 'price', 'subtotal');
    }



}


