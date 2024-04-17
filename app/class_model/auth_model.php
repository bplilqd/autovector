<?php

namespace model;

use model\connect\forUseMysqli;
use model\function\auth_function;
use view\auth_form;
use model\function\recaptcha_v2;
use model\function\translations;

class auth_model extends model implements interface_auth_model
{
    protected object $auth_function;
    public object $auth_form;
    public object $captcha;
    protected object $translations; // lang
    // other properties
    protected $input_data; // data for auth_form
    protected int $length_generate_pass = 8;

    public function __construct()
    {
        // set objects
        $this->set_objects();
    }

    public function set_and_setting()
    {
        // receiving data
        $data = $this->input_data;
        // reg or auth
        $this->registr_or_authorization($data);
        // collection a errors from classes
        $this->sending_error_message_from_classes();
        // count queries in database
        if ($this->mysql->count_query) {
            $this->count_query = count($this->mysql->count_query);
        }
    }

    protected function sending_error_message_from_classes()
    {
        // got error from captcha
        if ($this->captcha->error_arr) {
            $this->error($this->captcha->error_arr, 'captcha');
        }
        // got error from mysql
        if ($this->mysql->error_arr) {
            $this->error($this->mysql->error_arr, 'mysql');
        }
    }

    protected function set_new_auth_or_reg($set_phone, $phone, $pass)
    {
        // registr new user
        $this->set_registr($phone, $set_phone);
        // authorization
        $this->set_authorization($set_phone, $phone, $pass);
    }

    protected function registr_or_authorization($data)
    {
        if ($data) {
            if ($data['auth_form']['auth_submit']) {
                $phone = $data['auth_form']['phone'];
                $set_phone = $data['auth_form']['set_phone'];
                $pass = $data['auth_form']['pass'];
                if (RECAPTCHA_ON) {
                    // recaptcha false / true
                    $captcha = $this->captcha->captcha;
                    // with check
                    if ($captcha) {
                        $this->set_new_auth_or_reg($set_phone, $phone, $pass);
                    }
                    // without check
                } else {
                    $this->set_new_auth_or_reg($set_phone, $phone, $pass);
                }
            }
        }
    }

    protected function set_registr($phone, $set_phone)
    {
        if ($phone && !$set_phone) {
            $result = $this->check_user_to_db($phone);
            if (!$result) {

                // auth_function
                $pass = $this->auth_function->generateCode($this->length_generate_pass);
                $generate_hash = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass, $phone);
                // got error from auth_function
                $this->got_error_from_auth_function();

                // egistr user
                $this->registr_new_user($phone, $generate_hash);

                // отправляем пароль

                // уведомляем что отправили пароль
            }
        }
    }

    protected function authorization($phone, $pass_db, $generate_hash)
    {
        if ($pass_db && $pass_db == $generate_hash && !$this->error_arr['model']) {
            // authorization good

            // set hash cook
            $this->auth_set_cookie($generate_hash);

            // update user
            $sql = "UPDATE `user` SET `hash` = '$generate_hash' WHERE `user`.`phone` = $phone";
            $this->mysql->sql_update($sql);

            header("Location: ../..");
        } else {
            // authorization error
            $this->error_arr['model'][] = $this->translations->get_message('auth', 'incorrect_pass');
        }
    }

    protected function got_error_from_auth_function()
    {
        if ($this->auth_function->error_arr) {
            $this->error($this->auth_function->error_arr, 'auth_function');
        }
    }
    protected function set_authorization($set_phone, $phone, $pass)
    {
        if ($set_phone) {
            if ($pass) {
                $result = $this->check_user_to_db($phone);
                if ($result) {

                    $row = $this->mysql->query->fetch_assoc();
                    $pass_db = $row['pass'];

                    // auth_function
                    $generate_hash = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass, $phone);
                    // got error from auth_function
                    $this->got_error_from_auth_function();

                    $this->authorization($phone, $pass_db, $generate_hash);
                }
            } else {
                $this->error_arr['model'][] = $this->translations->get_message('auth', 'no_pass');
            }
        }
    }
    protected function auth_set_cookie($hash)
    {
        if ($hash) {
            setcookie("hash", $hash, time() + SET_COOK_TIME_HASH, "/");
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
        // set object for enter of language
        $this->translations = translations::getInstance();
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // auth form
        $this->auth_form = new auth_form;
        // other auth function
        $this->auth_function = new auth_function;
        // recaptcha v2
        $this->captcha = new recaptcha_v2;
    }
}
