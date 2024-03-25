<?php

namespace work;

use model\default_model;
use viwe\default_view;

class main_controller
{
    protected $viwe;
    protected $model;

    function __construct()
    {
        // array for model class
        $class_model = ['default_model'];
        // array for view class
        $class_view = ['default_view'];
        // autoload class
        $this->autoload_clas($class_model, $class_view);
        // set objects
        $this->viwe = new default_view;
        $this->model = new default_model;
    }

    // set autoload class
    protected function autoload_clas($class_model, $class_view)
    {
        // set path
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS;
        $this->new_load_class($class_model, $path_model); // autoload for model
        // set path
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $this->new_load_class($class_view, $path_model); // autoload for view

    }
    // method for autoload class
    protected function new_load_class($array, $path)
    {
        foreach ($array as $name_class) {
            require_once $path .  $name_class . '.php';
        }
    }
}
