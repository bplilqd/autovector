<?php

namespace controller;

class main_controller
{
    protected $model;
    // set new class to objects
    protected function set_object()
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
