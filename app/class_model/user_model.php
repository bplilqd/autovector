<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;

class user_model extends model
{
    protected object $mysql;

    public function __construct()
    {
        // set objects other
        $this->set_objects();
    }

    public function set_and_setting()
    {
        // got error from mysql
        if ($this->mysql->error_arr) {
            $this->error($this->mysql->error_arr, 'mysql');
        }
        // count queries in database
        if($this->mysql->count_query){
            $this->count_query = count($this->mysql->count_query);
        }
        
    }

    protected function set_objects()
    {
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set user
        $this->user_config = new user_config;
    }
}
