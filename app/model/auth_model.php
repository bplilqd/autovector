<?php

namespace model;

use model\connect\forUseMysqli;
use model\function\auth_function;
use view\form\auth_form;
use view\messages\message;
use model\function\recaptcha_v2;
use model\function\translations;
use controller\error\error_manager;
use model\whatsapp\whatsapp_connect;

class auth_model extends model implements interface_auth_model
{
    private object $message; // messages
    private object $whatsapp;
    private object $auth_function;
    public object $auth_form;
    public object $captcha;
    private object $translations; // lang
    private object $error_manager; // error
    // other properties
    private $input_data = []; // data for auth_form
    private int $length_generate_pass = 8;

    public function __construct()
    {
        // set objects
        $this->set_objects();
    }

    public function data_of_auth($data)
    {
        $this->input_data = $data;
    }

    // main method of model
    public function set_and_setting()
    {
        // receiving data
        $data = $this->input_data;
        // reg or auth
        $this->registr_or_authorization($data);
        // count queries in database
        if ($this->mysql->count_query) {
            $this->count_query = count($this->mysql->count_query);
        }
    }

    private function set_new_auth_or_reg($set_phone, $phone, $pass)
    {
        // registr new user
        $this->set_registr($phone, $set_phone);
        // authorization
        $this->set_authorization($set_phone, $phone, $pass);
    }

    private function registr_or_authorization($data)
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

    private function set_registr($phone, $set_phone)
    {
        if ($phone && !$set_phone) {
            $result = $this->check_user_to_db($phone);
            if (!$result) {

                // auth_function
                $pass = $this->auth_function->generateCode($this->length_generate_pass);
                $generate_hash = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass, $phone);

                if (!$this->error_manager->has_errors()) {
                    // egistr user
                    $this->registr_new_user($phone, $generate_hash);

                    // message with password
                    $message = $this->translations->get_message(
                        'auth',
                        'your_pass'
                    ) . ': ' . $pass;
                    // send pass
                    $this->whatsapp->msg_to($phone, $message);

                    // print info
                    $this->message->messages($this->translations->get_message(
                        'auth',
                        'successfully_sent'
                    ), 'info');
                }
            }
        }
    }

    private function authorization($phone, $pass_db, $generate_hash)
    {
        if ($pass_db && $pass_db == $generate_hash && !$this->error_manager->has_errors()) {
            // authorization good

            // set hash cook
            $this->auth_set_cookie($generate_hash);

            // update user
            $sql = "UPDATE `user` SET `hash` = '$generate_hash' WHERE `user`.`phone` = $phone";
            $this->mysql->sql_update($sql);

            header("Location: ../..");
        } else {
            // authorization error
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'auth',
                    'incorrect_pass'
                )
            );
        }
    }

    private function set_authorization($set_phone, $phone, $pass)
    {
        if ($set_phone) {
            if ($pass) {
                $result = $this->check_user_to_db($phone);
                if ($result) {

                    $row = $this->mysql->query->fetch_assoc();
                    $pass_db = $row['pass'];

                    // auth function -> create md5
                    $generate_hash = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass, $phone);

                    if (!$this->error_manager->has_errors()) {
                        $this->authorization($phone, $pass_db, $generate_hash);
                    }
                }
            } else {
                $this->error_manager->add_error(
                    $this->translations->get_message(
                        'auth',
                        'no_pass'
                    )
                );
            }
        }
    }
    private function auth_set_cookie($hash)
    {
        if ($hash) {
            setcookie("hash", $hash, time() + SET_COOK_TIME_HASH, "/", HOST);
        }
    }

    // is there a user in the database (db)
    private function check_user_to_db(int $phone)
    {
        $sql = "SELECT *  FROM `user` WHERE `phone` = $phone;";
        $result = $this->mysql->sql_select($sql, false);
        return $result;
    }

    private function registr_new_user($phone, $generate_hash)
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
            'language' => LANGUAGE,
            //             'hash' => '',
            'sec' => time()
        ];
        // add new user to db
        $this->mysql->insert_set_and_add($name_table, $array);
    }

    private function set_objects()
    {
        // for send messages in whatsApp
        $this->whatsapp = new whatsapp_connect;
        // setting error object
        $this->error_manager = error_manager::get_instance();
        // set object for enter of language
        $this->translations = translations::getInstance();
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // message
        $this->message = message::get_instance();
        // auth form
        $this->auth_form = new auth_form;
        // other auth function
        $this->auth_function = new auth_function;
        // recaptcha v2
        $this->captcha = new recaptcha_v2;
    }
}
