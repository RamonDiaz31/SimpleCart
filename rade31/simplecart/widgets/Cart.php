<?php

namespace Rade31\SimpleCart\Widgets;

use Backend\Classes\FormWidgetBase;


use Session;

class Cart extends FormWidgetBase
{

    //
    // Configurable properties
    //

    public $updateField;

    //
    // Object properties
    //

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'cart';

    /**
     * {@inheritDoc}
     */
    public function init()
    {

        $this->fillFromConfig([
            'updateField',

        ]);
    }


    public function render()
    {



        Session::remove($this->alias . '_cart');


        $this->vars['name'] = $this->getFieldName();




        $cart = $this->getCart($this->model);


        $this->vars['cart'] = $cart;


        $this->vars['updateField'] = '';
        $this->vars['updateValue'] = '';
        if ($this->updateField) {

            $this->vars['updateField'] = str_replace($this->fieldName, $this->updateField, $this->getFieldName());
            $this->vars['updateValue'] = array_key_exists('total', $cart) ? $cart['total'] : 0;
        }


        return $this->makePartial('body');
    }

    protected function loadAssets()
    {
        $this->addCss('css/cart.min.css');

        $this->addJs('js/cart.min.js');
    }

    public function onCartItemAdd()
    {


        $cart = $this->getCart($this->model);


        $product = \Rade31\SimpleCart\Models\Product::where('barcode', input('searchOne'))->first();


        if ($product) {
            $isNewItem = true;
            foreach ($cart['items'] as $index => $item) {
                if ($item['product_id'] == $product->id) {
                    $isNewItem = false;
                    break;
                }
            }

            if ($isNewItem) {
                $newItem = [
                    'product_id' => $product->id,
                    'barcode' => $product->barcode,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'quantity' => 1,
                    'subtotal' => $product->unit_price,

                ];
                $cart['items'][] = $newItem;
                $cart['total'] = $cart['total'] +  $newItem['subtotal'];
            } else {
                $cart['total'] = $cart['total'] -  $cart['items'][$index]['subtotal'];
                $cart['items'][$index]['quantity'] = $cart['items'][$index]['quantity'] + 1;

                $cart['items'][$index]['subtotal'] =  number_format((float) $cart['items'][$index]['price'] * $cart['items'][$index]['quantity'], 2, '.', '');
                $cart['total'] = $cart['total'] +   $cart['items'][$index]['subtotal'];
            }



            Session::put($this->alias . '_cart', $cart);




            $itemContainer = '#' . $this->getId('table-body');
            $itemContainer2 = '#' . $this->getId('table-foot');
            $this->vars['cart'] = $cart;
            $this->vars['name'] = $this->getFieldName();


            $extraData = [];

            if ($this->updateField) {

                $extraData['update_field'] = str_replace($this->fieldName, $this->updateField, $this->getFieldName());
                $extraData['update_value'] = array_key_exists('total', $cart) ? $cart['total'] : 0;
            }

            return [
                'extra_data' => $extraData,
                $itemContainer => $this->makePartial('tablebody'),
                $itemContainer2 => $this->makePartial('tablefoot')
            ];
        }
    }


    public function onCartItemAdd2()
    {

        $cart = $this->getCart($this->model);


        $product =  \Rade31\SimpleCart\Models\Product::find(input('search_add'));


        if ($product) {
            $isNewItem = true;
            foreach ($cart['items'] as $index => $item) {
                if ($item['product_id'] == $product->id) {
                    $isNewItem = false;
                    break;
                }
            }

            if ($isNewItem) {
                $newItem = [
                    'product_id' => $product->id,
                    'barcode' => $product->barcode,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'quantity' => 1,
                    'subtotal' => $product->unit_price,

                ];
                $cart['items'][] = $newItem;
                $cart['total'] = $cart['total'] +  $newItem['subtotal'];
            } else {
                $cart['total'] = $cart['total'] -  $cart['items'][$index]['subtotal'];
                $cart['items'][$index]['quantity'] = $cart['items'][$index]['quantity'] + 1;

                $cart['items'][$index]['subtotal'] =  number_format((float) $cart['items'][$index]['price'] * $cart['items'][$index]['quantity'], 2, '.', '');
                $cart['total'] = $cart['total'] +   $cart['items'][$index]['subtotal'];
            }



            Session::put($this->alias . '_cart', $cart);




            $itemContainer = '#' . $this->getId('table-body');
            $itemContainer2 = '#' . $this->getId('table-foot');
            $this->vars['cart'] = $cart;
            $this->vars['name'] = $this->getFieldName();


            $extraData = [];

            if ($this->updateField) {
                $extraData['update_field'] = str_replace($this->fieldName, $this->updateField, $this->getFieldName());
                $extraData['update_value'] = array_key_exists('total', $cart) ? $cart['total'] : 0;
            }

            return [
                'extra_data' => $extraData,
                $itemContainer => $this->makePartial('tablebody'),
                $itemContainer2 => $this->makePartial('tablefoot')
            ];
        }
    }


    public function onCartItemEdit()
    {

        $cart = $this->getCart($this->model);

        $product_id = input('cart_update_id');
        $newQuantity = input('cart_update_quantity');

        foreach ($cart['items'] as $index =>  &$item) {
            if ($item['product_id'] == $product_id) {

                $cart['total'] = $cart['total'] - $item['subtotal'];

                $cart['items'][$index]['quantity'] = $newQuantity;
                $cart['items'][$index]['subtotal'] = $newQuantity * $item['price'];

                $cart['total'] = $cart['total'] +   $cart['items'][$index]['subtotal'];

                break;
            }
        }

        Session::put($this->alias . '_cart', $cart);



    
        $this->vars['cart'] = $cart;
        $this->vars['name'] = $this->getFieldName();
        $extraData = [];

        $itemContainer = '#' . $this->getId('table-body');
        $itemContainer2 = '#' . $this->getId('table-foot');

        if ($this->updateField) {
            $extraData['update_field'] = str_replace($this->fieldName, $this->updateField, $this->getFieldName());
            $extraData['update_value'] = array_key_exists('total', $cart) ? $cart['total'] : 0;
        }

        return [
            'extra_data' => $extraData,
            $itemContainer => $this->makePartial('tablebody'),
            $itemContainer2 => $this->makePartial('tablefoot')
        ];
    }



    public function onRemoveCartItem()
    {
        $product_id = input('cart_delete_id');


        $cart = $this->getCart($this->model);


        foreach ($cart['items'] as $index => $item) {
            if ($item['product_id'] == $product_id) {
                $cart['total'] = $cart['total'] - $item['subtotal'];
                unset($cart['items'][$index]);
                unset($item);
                break;
            }
        }



        $this->vars['name'] = $this->getFieldName();

        if ($cart['context'] == 'update') {


            if (!array_key_exists('toDelete', $cart)) {

                $cart['toDelete'] = [];
            }

            $cart['toDelete'][] = $product_id;
            $this->vars['cart'] = $cart;
            $returnData['#' . $this->getId('deleteBinding')] = $this->makePartial('deletebinding');
        } else {
            $this->vars['cart'] = $cart;
        }
        Session::put($this->alias . '_cart', $cart);
        $extraData = [];
        $this->vars['name'] = $this->getFieldName();

        if ($this->updateField) {
            $extraData['update_field'] = str_replace($this->fieldName, $this->updateField, $this->getFieldName());
            $extraData['update_value'] = array_key_exists('total', $cart) ? $cart['total'] : 0;
        }


        $returnData['#' . $this->getId('table-body')] = $this->makePartial('tablebody');
        $returnData['#' . $this->getId('table-body')] = $this->makePartial('tablefoot');

        $returnData['extra_data'] = $extraData;
        return $returnData;
    }

    public function onSearchProduct()
    {
        $query = input('search') ?? '';

        $products = \Rade31\SimpleCart\Models\Product::where('name', 'LIKE', '%' . $query . '%')->get();

        $itemContainer = '#' . $this->getId('div-search-product');

        $this->vars['products'] = $products;

        return [
            $itemContainer => $this->makePartial('divsearchproducts'),

        ];
    }


    private function getCart($order)
    {

        if (empty($order->getAttributes())) {
            $order = null;
        }

        if (!$order) {
            $context = 'create';
        } else {
            $context = 'update';
        }



        $recreateCart = false;
        if (!Session::get($this->alias . '_cart')) {
            $recreateCart = true;
        } else {

            if ($context != Session::get($this->alias . '_cart')['context']) {

                $recreateCart = true;
            } elseif ($context == Session::get($this->alias . '_cart')['context'] && $order?->id != Session::get($this->alias . '_cart')['order_id']) {
                $recreateCart = true;
            }
        }


        //RecreateCart
        if ($recreateCart) {
            if ($context == 'create') {

                $cart =  [
                    'items' => [],
                    'total' => 0,
                    'context' => 'create',
                    'order_id' => null,

                ];
            } elseif ($context == 'update') {



                $cart['items'] =  [];

                if (count($order->products)) {
                    foreach ($order->products as $product) {
                        $item = [
                            'product_id' => $product->id,
                            'barcode' => $product->barcode,
                            'name' => $product->name,
                            'price' => (float) $product->pivot->price,
                            'quantity' => $product->pivot->quantity,
                            'subtotal' => (float) $product->pivot->subtotal,
                            'original_quantity' => $product->pivot->quantity,
                            'change_quantity' => 0,
                            'deleted' => false,
                        ];
                        $cart['items'][] = $item;
                    }
                }

                $cart['total'] = $order->total;
                $cart['original_total'] = $order->total;
                $cart['context'] = 'update';
                $cart['order_id'] = $order->id;
                //  $cart['moneyDifference'] = 0;


            }
        } else {
            $cart = Session::get($this->alias . '_cart');
        }



        Session::put($this->alias . '_cart', $cart);
        return $cart;
    }




    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {


        return $value;
    }
}
