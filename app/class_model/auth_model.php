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
    protected $input_data; // data for auth_form
    protected $length_generate_pass = 8;

    public function __construct()
    {
        // set objects
        $this->set_objects();

        // example error for model
        //$this->error_arr['model'][] = 'test error in the model';
    }

    public function set_and_settin_view()
    {
        $data = $this->input_data;
        if ($data) {
            // registr new user
            $this->set_registr($data);
            // authorization
            //...?
        }
        // data transfer and set -> view
        $this->view->content = $this->auth_form->form($this->input_data);
        // default set to name of current theme
        $this->view->user_theme = DESIGN_THEME; // theme default
        // default set to what is the dark or light theme
        $this->view->data_bs_theme = MODE_THEME; // mode default
        // got error from mysql
        $this->error($this->mysql->error_arr, 'mysql');
        // include theme
        $this->view->include_theme();
    }
    public function data_of_auth($data)
    {
        $this->input_data = $data;
        print_r($this->input_data);
    }

    protected function set_registr($data)
    {
        $phone = $data['auth_form']['phone'];
        if ($data['auth_form']['auth_submit'] && $phone) {
            $result = $this->check_user_to_db($phone);
            if (!$result) {
                $pass = $this->generateCode($this->length_generate_pass);
                $this->registr_new_user($phone, $pass);
                // уведомляем что отправили пароль
            }
        }
    }
    // is there a user in the database (db)
    protected function check_user_to_db(int $phone)
    {
        $sql = "SELECT *  FROM `user` WHERE `phone` = $phone;";
        $result = $this->mysql->sql_select($sql, false);
        return $result;
    }

    protected function registr_new_user($phone, $pass)
    {
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
        print_r($array);
        $this->mysql->insert_set_and_add($name_table, $array);
    }
    protected function generateCode($length = 6)
    {
        $chars = "abcdefikmprstuvwxyz123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }
    protected function set_objects()
    {
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // auth form
        $this->auth_form = new auth_form;
        // other auth function
        $this->auth_function = new auth_function;
        // set template
        $this->view = new ('view\\' . NAME_VIEW)();
    }
}
