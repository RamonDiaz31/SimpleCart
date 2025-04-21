<?php

namespace Rade31\SimpleCart\Models;

use Model;
use Rade31\SimpleCart\Models\OrderHasProduct;

use Winter\Storm\Database\Relations\BelongsToMany;
use BackendAuth;

/**
 * Model
 */
class Order extends Model
{
    use \Winter\Storm\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'rade31_simple_cart_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [

        'user_id' => 'required',

    ];
    public function getUserIdAttribute()
    {

        return $this->exists ?: BackendAuth::user()->id;
    }


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'rade31_simple_cart_order_has_products', 'order_id', 'product_id')->using(OrderHasProduct::class)->withPivot('quantity', 'price', 'subtotal');
    }



 



}
