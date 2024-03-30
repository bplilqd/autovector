<?php

namespace controller;

class auth_controller extends main_controller
{

    function __construct()
    {
        // обработка запросов пользователя check data input from user

        // add names for class for set autoload 
        $this->start_name_class();
        // set objects of model
        $this->set_object();
        // sent data
        $data=[];
        $this->model->data_of_auth($data);
    }

    // start name class
    protected function start_name_class()
    {
        // array for model class
        $class_model = [NAME_MODEL];
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
