<?php

namespace controller;

class default_controller extends main_controller
{

    function __construct()
    {
        // set request
        $this->set_request();
        // add names for class for set autoload 
        $this->start_name_class();
        // set object of model
        $this->set_object_model();
    }

    // start name class
    protected function start_name_class()
    {
        // array for model -> connect class
        $class_mosel_setings = ['useMysqli', 'interfaceForUseMysqli', 'forUseMysqli'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS . 'connect' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model -> settings class
        $class_mosel_setings = ['interface_user_classe', 'user_config'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS . 'settings' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model class
        $class_model = [NAME_MODEL, 'znach_array'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS;
        $array[] = [$class_model, $path_model];

        // array for view class
        $class_view = ['interface_set_theme', NAME_VIEW];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }
}
