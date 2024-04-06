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
        // set to name of current theme
        $this->view->user_theme = $this->user_config->user_theme;
        // set to what is the dark or light theme
        $this->view->data_bs_theme = $this->user_config->data_bs_theme;
        // got error from mysql
        if ($this->mysql->error_arr) {
            $this->error($this->mysql->error_arr, 'mysql');
        }
        print_r($this->error_arr);
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
        $this->view = new ('view\\'.NAME_VIEW);
    }
}
