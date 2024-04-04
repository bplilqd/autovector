<?php

namespace model;

class model
{
    protected $view;
    static $error_arr; // error 

    // collect errors
    public function error($array, $name)
    {
        $this->error_arr[$name] = $array;
    }
}
