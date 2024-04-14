<?php

namespace model;

class model
{
    // objects
    protected object $mysql;
    public object $user_config;

    public $error_arr; // error
    //static $success_arr; // success
    //static $warning_arr; // warning
    //static $info_arr; // danger

    public string $hash = ''; // id user of the hash
    public bool $auth = false; // auth bool FALSE or TRUE

    public $count_query; // count request in db
    
    // collecter of errors
    public function error($array, $name)
    {
        $this->error_arr[$name] = $array;
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
