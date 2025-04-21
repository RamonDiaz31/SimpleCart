<?php

namespace Rade31\SimpleCart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;


class Orders extends Controller
{
  

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];




    public function __construct()
    {

        parent::__construct();
    
        BackendMenu::setContext('Rade31.SimpleCart', 'simplecart', 'orders');
    }



}
