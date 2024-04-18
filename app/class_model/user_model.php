<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;

class user_model extends model
{
    protected object $mysql;
    // output data -> view
    public $data_user;

    public function __construct()
    {
        // set objects other
        $this->set_objects();

    }

    public function set_and_setting()
    {
        // if authorized. if allowed to continue
        if ($this->auth) {
            // data user for sent to wiew
            $this->set_data_user_for_view();
        }
        // got error from mysql
        if ($this->mysql->error_arr) {
            $this->error($this->mysql->error_arr, 'mysql');
        }
        // count queries in database
        if ($this->mysql->count_query) {
            $this->count_query = count($this->mysql->count_query);
        }
    }

    protected function set_data_user_for_view()
    {
        $user_config = $this->user_config;

        $user_data = [
            'name' => $user_config->name,
            'phone' => '+' . $user_config->phone,
            'email' => $user_config->email,
            'user_theme' => $user_config->user_theme,
            'data_bs_theme' => $user_config->data_bs_theme,
            'date' => date("d.m.Y", $user_config->sec)
        ];

        $this->data_user = $user_data;
    }

    protected function set_objects()
    {
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set user
        $this->user_config = new user_config;
    }
}
