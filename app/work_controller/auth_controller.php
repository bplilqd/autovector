<?php

namespace controller;

class auth_controller extends main_controller
{

    function __construct()
    {
        // обработка запросов пользователя

        // add names for class for set autoload 
        $this->start_name_class();
        // set objects of model
        $this->set_object();
    }

    // start name class
    protected function start_name_class()
    {
        // array for model -> settings class
        $class_mosel_setings = ['interface_user_classe', 'user_config'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS . 'settings' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model class
        $class_model = [NAME_MODEL, 'znach_array'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS;
        $array[] = [$class_model, $path_model];

        // array for view class
        $class_view = ['default_view'];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }

}
