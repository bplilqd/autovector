<?php

namespace work;

class main_controller
{
    protected $viwe;
    protected $model;

    // method for autoload class
    protected function new_load_class($array, $path)
    {
        foreach ($array as $name_class) {
            require_once $path .  $name_class . '.php';
        }
    }
}
