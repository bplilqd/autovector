<?php

namespace model;

use viwe\default_view;
use model\settings\user_config;
use model\connect\forUseMysqli;

class default_model extends model
{
    protected $user_config;
    protected $znach_array;
    protected $mysql;
    public function __construct()
    {
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set objects other
        $this->set_objects();
    }

    protected function set_and_settin_viwe()
    {
        // имитируем запрос с базы данных
        // и устанваливаем полученые данные
        $this->query_data_user_db();
        // set to name of current theme
        $this->viwe->user_theme = $this->user_config->user_theme;
        // set to what is the dark or light theme
        $this->viwe->data_bs_theme = $this->user_config->data_bs_theme;
        $this->viwe->include_theme();
    }

    protected function set_objects()
    {
        $this->user_config = new user_config;
        $this->znach_array = new znach_array;
        $this->viwe = new default_view;
        // option/settings
        $this->set_and_settin_viwe();
    }

    protected function query_data_user_db()
    {
        // real connect db
        // .....?
        // imitation
        $array = ['user_theme' => 'design', 'data_bs_theme' => "dark"];
        $this->user_config->input_data($array);
    }
}
