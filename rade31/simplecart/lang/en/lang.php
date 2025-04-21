<?php return [
    'plugin' => [
        'name' => 'Simple Cart',
        'description' => 'Allows to demostrate the insertion of pivot data on a BelongsToMany Raltion'
    ],
    'menu' => [
        'label' => 'Simple Cart',
        'orders' => 'Orders',
        'products' => 'Products'
    ],
    'app' => [
        'product' => [
            'name' => 'Name',
            'description' => 'Description',
            'purchase_price' => 'Purchase Price',
            'unit_price' => 'Unit Price',
            'barcode' => 'Code',

        ],
        'order' => [
            'total' => 'Total',
            'products' => [
                '' => 'Products',
                'code' => 'Code',
                'product' => 'Product',
                'quantity' => 'Quantity',
                'price' => 'Price',
                'subtotal' => 'Subtotal',
                'options' => 'Options'
            ],

        ]

    ],
    'form' => [
        'all' => 'View all Products'
    ]


];
