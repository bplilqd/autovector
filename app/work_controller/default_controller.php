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

        // model ->
        // set user auth
        $this->model->set_user($this->hash);
        // start work for to model -> option/settings
        $this->model->set_and_setting();
        // set of the settings user
        $this->settings_user();

        // view ->
        // for print errors
        $this->view->error_print();
        // set_menu
        if ($this->model->auth) {
            $this->view->set_menu();
        }
        // title
        $this->view->setting_properties('title', $this->translations->get_message('content_page', 'welcome'));
        // set_foot
        $this->view->set_foot($this->model->count_request());
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

        // array for model -> function class
        $class_mosel_setings = ['znach_array'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS . 'function' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model -> settings class
        $class_mosel_setings = ['interface_user_classe', 'user_config'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS . 'settings' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model class
        $class_model = ['interface_model', NAME_MODEL];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS;
        $array[] = [$class_model, $path_model];

        // array for view class
        $class_view = ['interface_auth_view', NAME_VIEW];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }
}
