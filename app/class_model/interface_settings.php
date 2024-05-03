<?php

namespace model;

interface interface_settings
{
    // set user
    public function set_user($hash);
    // method work of class
    public function set_and_setting();
    // count queries in database
    public function count_request();
    // setting form
    public function edit_form($data);
    // check how many directories are inside for lang and templat
    public function scan_dir_lang_and_template();
}
