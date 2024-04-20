<?php

namespace controller;

use view\not_authorized_view;

class user_controller extends main_controller
{

    protected object $not_authorized;

    function __construct()
    {
        // controller ->
        $this->set_in_controller();
        // model ->
        $this->set_in_model();
        // view ->
        $this->set_in_view();
    }

    protected function set_in_controller()
    {
        // controller ->
        // load casses - add names for class for set autoload 
        $this->start_name_class();
        // standart methods -> set request, set hash from browser, set object of model and others...
        $this->set_standart();
    }

    protected function set_in_model()
    {
        // model ->
        // set user auth
        $this->model->set_user($this->hash);
        // start work for to model -> option/settings
        $this->model->set_and_setting();
        // set of the settings user
        $this->settings_user();
    }

    protected function set_in_view()
    {
        // view ->
        if ($this->model->auth) {
            // if authorized -> view...
            // sent data for set in wiew
            $this->view->input_data_user($this->model->data_user);
            // set title
            $title_user_page = $this->translations->get_message('panel_user', 'title_user_page');
            $this->view->setting_properties('title', $title_user_page);
            // set content
            $this->view->set_content();
            // set menu
            $this->view->set_menu();
            // set_foot
            $this->view->set_foot($this->model->count_query);
            // for print errors
            $this->view->error_print(); 
            // include theme
            $this->view->include_theme();
        } else {
            // if not authorized -> not_authorized
            // error and redirect
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'auth',
                    'not_authorized'
                )
            );
            header("refresh:5; url=../auth");
            // set this method if there is no authorization
            $this->set_for_not_authorized();
        }
    }

    protected function set_for_not_authorized()
    {
        // set other object of view
        $this->not_authorized = new not_authorized_view;
        // set_foot
        $this->not_authorized->set_foot($this->model->count_query);
        // for print errors
        $this->not_authorized->error_print();
        // include theme
        $this->not_authorized->include_theme();
    }

    // start name class
    protected function start_name_class()
    {
        // array for model -> connect class
        $class_mosel_setings = ['interfaceForUseMysqli', 'useMysqli', 'forUseMysqli'];
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
        $class_model = [NAME_MODEL];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS;
        $array[] = [$class_model, $path_model];

        // array for view class
        $class_view = ['interface_auth_view', 'interface_user_view', 'not_authorized_view', NAME_VIEW];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }
}
