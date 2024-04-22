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

    // controller ->
    protected function set_in_controller()
    {
        // load casses - add names for class for set autoload 
        $this->start_name_class();
        // standart methods -> set request, set hash from browser, set object of model and others...
        $this->set_standart();
    }

    // model ->
    protected function set_in_model()
    {
        // set user auth
        $this->model->set_user($this->hash);
        // start work for to model -> option/settings
        $this->model->set_and_setting();
        // set of the settings user
        $this->settings_user();
    }

    // view ->
    protected function set_in_view()
    {
        // settings
        $this->eddit_user_data();
        // logout
        $this->logout();
        if ($this->model->auth) {
            // if authorized -> view...
            // sent data for set in wiew
            $this->view->input_data_user($this->model->data_user);
            // set title
            $title_user_page = $this->translations->get_message(
                'panel_user',
                'title_user_page'
            );
            $this->view->setting_properties('title', $title_user_page);
            // set content
            $this->view->set_content();
            // set menu
            $this->view->set_menu();
            // more if authorized
            $this->more_setting_default('view');
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
            // set other object of view
            $this->not_authorized = new not_authorized_view;
            // set this method if there is no authorization
            $this->more_setting_default('not_authorized');
        }
    }

    protected function eddit_user_data()
    {
        if ($this->request) {
            if (isset($this->request['eddit_user_data'])) {
            }
        }
    }

    protected function go_out()
    {
        if ($this->model->auth) {
            $hash = $this->hash;
            // куки записать хаш в браузер
            setcookie("hash", $hash, time() - SET_COOK_TIME_HASH, "/");
            // редирект на нужную страницу
            header("Location: /");
        }
    }

    protected function logout()
    {
        if ($this->request) {
            if (isset($this->request['logout'])) {
                if (!$this->model->auth) {
                    // error and redirect
                    $this->error_manager->add_error(
                        $this->translations->get_message(
                            'auth',
                            'already_logged_out'
                        )
                    );
                }
                // logged out
                $this->go_out();
            }
        }
    }

    protected function more_setting_default($view_namme)
    {
        // set_foot
        $this->$view_namme->set_foot($this->model->count_query);
        // for print errors
        $this->$view_namme->error_print();
        // include theme
        $this->$view_namme->include_theme();
    }

    // start name class
    protected function start_name_class()
    {
        // array for view -> form
        $class_view_form = [
            'interface_form',
            'form',
            'edit_form_user'
        ];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS . 'form' . DS;
        $array[] = [$class_view_form, $path_model];

        // array for model -> connect class
        $class_mosel_setings = [
            'interfaceForUseMysqli',
            'useMysqli',
            'forUseMysqli'
        ];
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
        $class_view = [
            'interface_auth_view',
            'interface_user_view',
            'not_authorized_view',
            NAME_VIEW
        ];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }
}
