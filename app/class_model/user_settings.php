<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;

class user_settings extends model implements interface_model
{
    protected object $mysql;
    protected object $edit_form_user;
    // output data -> view
    public $data_user = [];

    public function __construct()
    {
        // set objects other
        $this->set_objects();
    }

    public function set_and_setting()
    {
        // if authorized. if allowed to continue
        if ($this->auth) {

        }
    }

    private function set_objects()
    {
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set user
        $this->user_config = new user_config;
    }
}
