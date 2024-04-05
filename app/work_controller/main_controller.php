<?php

namespace controller;

class main_controller
{
    protected $model; // model
    protected $request; // request
    static $error_arr; // error

    public $hash; // id user of the hash
    public bool $auth; // auth bool FALSE or TRUE

    // set request
    protected function set_request()
    {
        if ($_REQUEST) {
            $this->request = $_REQUEST;
        }
    }

    // set new class to objects
    protected function set_object_model()
    {

        $this->model = new ('model\\' . NAME_MODEL);
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
