<?php

namespace model;

use model\connect\forUseMysqli;
use controller\work\auth\auth_function;
use view\auth_form;

class auth_model extends model
{
    protected $mysql;
    protected $auth_function;
    protected $auth_form;

    public function __construct()
    {
        // set objects
        $this->set_objects();
        // reg new user
        //$this->registr_new_user();
        // work to wiew -> option/settings
        $this->set_and_settin_view();
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

    protected function set_and_settin_view()
    {
        $this->view->content = $this->auth_form->form();
        // default set to name of current theme
        $this->view->user_theme = DESIGN_THEME; // theme default
        // default set to what is the dark or light theme
        $this->view->data_bs_theme = MODE_THEME; // mode default
        $this->view->include_theme();
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
        // auth form
        $this->auth_form = new auth_form;
        // set template
        $this->view = new ('view\\' . NAME_VIEW);
        // other auth function
        $this->auth_function = new auth_function;
    }
}
