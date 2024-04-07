<?php

namespace model;

use model\connect\forUseMysqli;
use controller\work\auth\auth_function;
use view\auth_form;

class auth_model extends model implements interface_auth_model
{
    protected object $auth_function;
    protected object $auth_form;
    // other properties
    protected $input_data; // data for auth_form
    protected int $length_generate_pass = 8;
    protected string $redirect = SITE_URL;

    public function __construct()
    {
        // set objects
        $this->set_objects();

        // example error for model
        //$this->error_arr['model'][] = 'test error in the model';
    }

    public function set_and_setting_view()
    {
        // receiving data
        $data = $this->input_data;
        // reg or auth
        $this->registr_or_authorization($data);
        // data transfer and set -> view
        $this->view->content = $this->auth_form->form($data);
        // default set to name of current theme
        $this->view->user_theme = DESIGN_THEME; // theme default
        // default set to what is the dark or light theme
        $this->view->data_bs_theme = MODE_THEME; // mode default
        // got error from mysql
        if ($this->mysql->error_arr) {
            $this->error($this->mysql->error_arr, 'mysql');
        }
        // for print errors
        $this->view->error_print($this->error_arr);
        // include theme
        $this->view->include_theme();
    }

    protected function registr_or_authorization($data)
    {
        if ($data) {
            if ($data['auth_form']['auth_submit']) {

                $phone = $data['auth_form']['phone'];
                $set_phone = $data['auth_form']['set_phone'];
                $pass = $data['auth_form']['pass'];

                // registr new user
                $this->set_registr($phone, $set_phone);

                // authorization
                $this->set_authorization($set_phone, $phone, $pass);
            }
        }
    }

    protected function set_registr($phone, $set_phone)
    {
        if ($phone && !$set_phone) {
            $result = $this->check_user_to_db($phone);
            if (!$result) {

                $pass = $this->auth_function->generateCode($this->length_generate_pass);
                $generate_hash = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass, $phone);

                // egistr user
                $this->registr_new_user($phone, $generate_hash);
                // отправляем пароль
                // уведомляем что отправили пароль открываем поле ввода пароля
            }
        }
    }

    protected function authorization($pass_db, $generate_hash)
    {
        if ($pass_db && $pass_db == $generate_hash && !$this->error_arr['model']) {
            // authorization good
            // set hash cook
            $this->auth_set_cookie($generate_hash);
            // ...set public $hash; // id user of the hash and public bool $auth; // auth bool FALSE or TRUE
            $this->view->system_mesage = 'authorization good';
            header("Location: ../../../..");
        } else {
            // authorization error
            $this->error_arr['model'][] = 'Incorrect password.';
        }
    }

    protected function auth_set_cookie($hash) {
        if ($hash) {
            setcookie("hash", $hash, time() + SET_COOK_TIME_HASH, "/");
        }
    }

    protected function set_authorization($set_phone, $phone, $pass)
    {
        if ($set_phone && $pass) {
            $result = $this->check_user_to_db($phone);
            if ($result) {

                $row = $this->mysql->query->fetch_assoc();
                $pass_db = $row['pass'];

                $generate_hash = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass, $phone);
                $this->authorization($pass_db, $generate_hash);
            }
        }
    }

    public function data_of_auth($data)
    {
        $this->input_data = $data;
        //print_r($this->input_data);
    }


    // is there a user in the database (db)
    protected function check_user_to_db(int $phone)
    {
        $sql = "SELECT *  FROM `user` WHERE `phone` = $phone;";
        $result = $this->mysql->sql_select($sql, false);
        return $result;
    }

    protected function registr_new_user($phone, $generate_hash)
    {
        $name_table = 'user';
        $array = [
            //            'login' => '',
            //            'name' => '',
            'phone' => $phone,
            //            'email' => '',
            'pass' => $generate_hash,
            'user_theme' => DESIGN_THEME,
            'data_bs_theme' => MODE_THEME,
            //             'hash' => '',
            'sec' => time()
        ];
        // add new user to db
        $this->mysql->insert_set_and_add($name_table, $array);
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
