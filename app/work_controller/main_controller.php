<?php

namespace work;

class main_controller
{
    protected $model;

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
            $this->new_load_class($value[0], $value[1]); // to autoload

        }
    }
}
