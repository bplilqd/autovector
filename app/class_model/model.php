<?php

namespace model;

class model
{
    protected $view;
    static $error_arr; // error
    static $success_arr; // success
    static $warning_arr; // warning
    static $info_arr; // danger

    // collect errors
    public function error($array, $name)
    {
        $this->error_arr[$name] = $array;
    }
}
