<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;
use model\function\znach_array;

class default_model extends model
{
    protected object $znach_array;
    protected object $mysql;

    public function __construct()
    {
        // set objects other
        $this->set_objects();
    }

    public function set_and_setting()
    {
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
        // set new
        $this->znach_array = new znach_array;
    }
}
