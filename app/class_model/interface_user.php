<?php

namespace model;

interface interface_user
{
    // set user
    public function set_user($hash);
    // method work of class
    public function set_and_setting();
    // setting form
    public function edit_form($data);
    // count queries in database
    public function count_request();
}
