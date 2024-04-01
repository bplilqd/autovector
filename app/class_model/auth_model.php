<?php

namespace model;

use model\connect\forUseMysqli;
use controller\work\auth\auth_function;

class auth_model extends model
{
    protected $mysql;
    protected $auth_function;
    
    public function __construct()
    {
        // set objects
        $this->set_objects();
        // reg new user
        //$this->registr_new_user();
    }

    protected function registr_new_user()
    {
        // check user in db
        // ...?
        $phone = 79214604140;
        $pass = '123456qwerty';
        $generate_hash = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass, $phone);
        $name_table = 'user';
        $array = [
//            'login' => '',
//            'name' => '',
            'phone' => $phone,
//            'email' => '',
            'pass' => $generate_hash,
            'user_theme' => DESIGN_THEME,
            'data_bs_theme' => MODE_THEME,
            'hash' => $generate_hash,
            'sec' => time()
        ];
        // add new user to db
        $this->mysql->insert_set_and_add($name_table, $array);
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
        $this->viwe = new ('viwe\\'.NAME_VIEW);
        // other auth function
        $this->auth_function = new auth_function;
        // option/settings
        $this->set_and_settin_viwe();
    }
}
