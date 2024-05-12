<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;

class default_model extends model implements interface_model
{
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
    }
}
