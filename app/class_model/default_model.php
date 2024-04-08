<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;

class default_model extends model
{
    protected object $znach_array;
    protected object $mysql;

    public function __construct()
    {
        // set objects other
        $this->set_objects();
    }

    public function set_and_setting_view()
    {
        // got error from mysql
        if ($this->mysql->error_arr) {
            $this->error($this->mysql->error_arr, 'mysql');
        }
        // for print errors
        $this->view->error_print($this->error_arr);
        // set_menu
        $this->view->set_menu($this->auth);
        // set_foot
        $this->view->set_foot($this->mysql->count_query);
        // include theme
        $this->view->include_theme();
    }

    protected function set_objects()
    {
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set user
        $this->user_config = new user_config;
        // set new
        $this->znach_array = new znach_array;
        // set template
        $this->view = new ('view\\' . NAME_VIEW);
    }
}
