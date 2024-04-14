<?php

namespace controller;

class main_controller
{
    protected object $model; // model
    protected object $view;

    protected $request; // request
    protected $error_arr; // error

    public string $hash = ''; // id user of the hash

    protected function set_standart()
    {
        // set request
        $this->set_request();
        // set hash from browser
        $this->set_hash_check();
        // set object of model
        $this->set_object_model_and_view();
    }

    protected function settings_user()
    {
        if ($this->model->auth) {
            // set to name of current theme
            $this->view->user_theme = $this->model->user_config->user_theme;
            // set to what is the dark or light theme
            $this->view->data_bs_theme = $this->model->user_config->data_bs_theme;
        }
    }
    protected function set_hash_check()
    {
        if (USER_HASH) {
            $this->hash = USER_HASH;
        }
    }

    // set request
    protected function set_request()
    {
        if ($_REQUEST) {
            $this->request = $_REQUEST;
        }
    }

    // set new class to objects
    protected function set_object_model_and_view()
    {
        // set model
        $this->model = new ('model\\' . NAME_MODEL);
        // set view -> template
        $this->view = new ('view\\' . NAME_VIEW);
    }

    // method for autoload class
    protected function new_load_class($array, $path)
    {
        foreach ($array as $name_class) {
            require_once $path .  $name_class . '.php';
        }
    }

    // set for autoload class
    protected function autoload_class($array)
    {
        foreach ($array as $value) {
            // to autoload
            $this->new_load_class($value[0], $value[1]);
        }
    }
}
