<?php

namespace Rade31\SimpleCart;


use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Simple Cart',
            'description' => 'Plugin for testing inserting pivot data',
            'author'      => 'Rade31',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerSettings() {}

    public function boot() {}

    public function registerFormWidgets()
    {
        return [
            'Rade31\SimpleCart\Widgets\Cart' => 'cart',

        ];
    }
}
