<?php

namespace model;

use viwe\default_view;
use model\connect\forUseMysqli;

class auth_model extends model
{
    protected $mysql;
    public function __construct()
    {
        // set objects
        $this->set_objects();
    }

    protected function set_and_settin_viwe()
    {
        // default set to name of current theme
        $this->viwe->user_theme = DESIGN_THEME; // theme default
        // default set to what is the dark or light theme
        $this->viwe->data_bs_theme = MODE_THEME; // mode default
        $this->viwe->include_theme();
    }

    public function data_of_auth($data)
    {
        // данные для запроса в базу данных
        // авторизационные, регистрационные и т.д.
    }

    protected function set_objects()
    {
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set template
        $this->viwe = new default_view;
        // option/settings
        $this->set_and_settin_viwe();
    }

}
