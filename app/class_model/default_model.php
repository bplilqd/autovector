<?php

namespace model;

use viwe\default_view;
use model\settings\user_config;

class default_model extends model
{
    protected $user_config;
    protected $znach_array;
    public function __construct()
    {
        // set objects
        $this->set_objects();
        // имитируем запрос с базы данных
        // и устанваливаем полученые данные
        $this->query_data_user_db();
    }

    protected function set_objects()
    {
        $this->user_config = new user_config;
        $this->znach_array = new znach_array;
        $this->viwe = new default_view;
    }

    protected function query_data_user_db()
    {
        $array = ['user_theme' => 'dark_theme'];
        $this->user_config->input_data($array);
    }
}
