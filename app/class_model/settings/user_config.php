<?php

namespace model\settings;

class user_config implements interface_user_classe
{
    public $user_theme; // name theme for use user
    public $data_bs_theme;
    public $array; // array data
    public function input_data($array)
    {
        $this->array = $array;
        $this->set_data();
    }
    protected function set_data()
    {
        $this->user_theme = $this->array['user_theme']; // set name for the user theme
        $this->data_bs_theme = $this->array['data_bs_theme']; // set for change dark or light
    }
}
