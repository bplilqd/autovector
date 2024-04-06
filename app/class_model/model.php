<?php

namespace model;

class model
{
    // objects
    protected object $mysql;
    protected object $view;
    protected object $user_config;

    static $error_arr; // error
    static $success_arr; // success
    static $warning_arr; // warning
    static $info_arr; // danger

    public string $hash = ''; // id user of the hash
    public bool $auth = false; // auth bool FALSE or TRUE

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
                // set to name of current theme
                $this->view->user_theme = $this->user_config->user_theme;
                // set to what is the dark or light theme
                $this->view->data_bs_theme = $this->user_config->data_bs_theme;
                // set online sec
            }
        }
    }
}
