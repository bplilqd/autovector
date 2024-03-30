<?php

namespace model;

use viwe\default_view;

class auth_model extends model
{

    public function __construct()
    {
        // set objects
        $this->set_objects();
    }

    public function data_of_auth($data)
    {
        // данные для запроса в базу данных
        // авторизационные, регистрационные и т.д.
    }

    protected function set_objects()
    {
        $this->viwe = new default_view;
    }
}
