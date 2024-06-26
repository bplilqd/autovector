<?php

namespace model;

class model
{
    // objects
    protected object $mysql;
    public object $user_config;

    public string $hash = ''; // id user of the hash
    public bool $auth = false; // auth bool FALSE or TRUE

    public $count_query; // count request in db

    public function count_request()
    {
        // count queries in database
        if ($this->mysql->count_query) {
            $this->count_query = count($this->mysql->count_query);
            return $this->count_query;
        }
    }
    
    public function set_user($hash)
    {
        if ($hash) {
            $sql = "SELECT * FROM `user` WHERE `hash` = '$hash'";
            // query
            $result = $this->mysql->sql_select($sql, FALSE);
            if ($result) {
                $this->auth = TRUE;
                $this->hash = $hash;
                // got data of user
                $row = $this->mysql->query->fetch_assoc();
                // set user
                $this->user_config->input_data($row);
                // set online sec
            }
        }
    }
}
