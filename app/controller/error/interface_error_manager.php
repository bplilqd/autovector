<?php

namespace controller\error;

interface interface_error_manager
{
    // if there is no object, then install it once
    public static function get_instance();
    // add error
    public function add_error($error);
    // get errors
    public function get_errors();
    // check errors
    public function has_errors();
}
