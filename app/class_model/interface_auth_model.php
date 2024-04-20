<?php

namespace model;

interface interface_auth_model
{
    // method work of class
    public function set_and_setting();
    // data of user got from form
    public function data_of_auth($data);
    // set user
    public function set_user($hash);
}
