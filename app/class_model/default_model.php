<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;

class default_model extends model
{
    protected $user_config;
    protected $znach_array;
    protected $mysql;

    public function __construct()
    {
        // set objects other
        $this->set_objects();
    }

    protected function set_and_settin_view()
    {
        // имитируем запрос с базы данных
        // и устанваливаем полученые данные
        $this->query_data_user_db();
        // set to name of current theme
        $this->view->user_theme = $this->user_config->user_theme;
        // set to what is the dark or light theme
        $this->view->data_bs_theme = $this->user_config->data_bs_theme;
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
        // option/settings
        $this->set_and_settin_view();
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
