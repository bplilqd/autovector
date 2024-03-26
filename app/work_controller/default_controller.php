<?php

namespace work;

use model\znach_array;

class default_controller extends main_controller
{

    

    function __construct()
    {
        // обработка запросов пользователя

        // add name for set autoload for class
        $this->start_name_class();
        // set objects
        $this->set_object();
    }

    // objects
    protected function set_object()
    {
        // set new class to objects
        $name_model = 'model\\' . NAME_MODEL;
        $this->model = new $name_model;
    }

    // start name class
    protected function start_name_class()
    {
        // array for model class
        $class_model = [NAME_MODEL, 'znach_array'];
        // array for view class
        $class_view = ['default_view'];
        // autoload class
        $this->autoload_clas($class_model, $class_view);
    }

    // set for autoload class
    protected function autoload_clas($class_model, $class_view)
    {
        // set path for model
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS;
        $this->new_load_class($class_model, $path_model); // autoload for model
        // set path for view
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $this->new_load_class($class_view, $path_model); // autoload for view

    }
}
