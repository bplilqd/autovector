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
    }

    protected function set_and_settin_viwe()
    {
        // имитируем запрос с базы данных
        // и устанваливаем полученые данные
        $this->query_data_user_db();
        $this->viwe->user_theme = $this->user_config->user_theme;
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
        $array = ['user_theme' => 'design', 'data_bs_theme' => "light"];
        $this->user_config->input_data($array);
    }
}
