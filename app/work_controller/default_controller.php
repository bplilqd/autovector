<?php

namespace controller;

class default_controller extends main_controller
{

    function __construct()
    {
        // controller ->
        // load casses - add names for class for set autoload 
        $this->start_name_class();
        // standart methods -> set request, set hash from browser, set object of model and others...
        $this->set_standart();
        // sending error to model
        if ($this->error_arr) {
            $this->model->error($this->error_arr, 'controller');
        }

        // model ->
        // set user auth
        $this->model->set_user($this->hash);
        // start work for to model -> option/settings
        $this->model->set_and_setting();

        // view ->
        $this->settings_user();
        // for print errors
        $this->view->error_print($this->model->error_arr);
        // set_menu
        $this->view->set_menu($this->model->auth);
        // set_foot
        $this->view->set_foot($this->model->count_query);
        // include theme
        $this->view->include_theme();
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
