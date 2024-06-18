<?php

namespace model;

use model\connect\forUseMysqli;
use model\function\auth_function;
use view\form\remind_password_form;
use model\function\recaptcha_v2;
use model\function\translations;
use controller\error\error_manager;
use model\whatsapp\whatsapp_connect;

class auth_remind_password extends model implements interface_auth_model
{
    private object $whatsapp;
    private object $auth_function;
    public object $remind_password_form;
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
        $this->start_check_user_and_sent_pas($data);
        // count queries in database
        if ($this->mysql->count_query) {
            $this->count_query = count($this->mysql->count_query);
        }
    }

    private function start_check_user_and_sent_pas($data)
    {
        if ($data) {
            if ($data['remind_password_form']['auth_remind_pass']) {
                $phone = $data['remind_password_form']['phone'];
                if (RECAPTCHA_ON) {
                    // recaptcha false / true
                    $captcha = $this->captcha->captcha;
                    // with check
                    if ($captcha) {
                        $this->check_user_and_sent_pas($phone);
                    }
                    // without check
                } else {
                    $this->check_user_and_sent_pas($phone);
                }
            }
        }
    }

    private function check_user_and_sent_pas($phone)
    {
        if ($phone) {
            // check phone number
            $result_phone = $this->check_user_to_db($phone);
            if ($result_phone) {
                // create new pass
                $pass_new = $this->auth_function->generateCode($this->length_generate_pass);
                // create as hash
                $pass = $this->auth_function->create_md5_to_auth_phone(SECRET_KEY, $pass_new, $phone);

                // update password in database
                $sql = "UPDATE `user` SET `pass` = '$pass' WHERE `phone` =" . $phone;
                $this->mysql->sql_update($sql);

                // message with password
                $message = $this->translations->get_message(
                    'auth',
                    'your_pass'
                ) . ': ' . $pass_new;
                // send pass
                $this->whatsapp->msg_to($phone, $message);

                // redirect user
                header("Location: " . SITE_URL . DS . "panel" . DS . "auth?phone=$phone&auth_submit=auth_submit");
            } else {
                $this->error_manager->add_error(
                    $this->translations->get_message(
                        'auth',
                        'no_such_number_in_db'
                    )
                );
            }
        }
    }

    // is there a user in the database (db)
    private function check_user_to_db(int $phone)
    {
        $sql = "SELECT *  FROM `user` WHERE `phone` = $phone;";
        $result = $this->mysql->sql_select($sql, false);
        return $result;
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
        // auth form
        $this->remind_password_form = new remind_password_form;
        // other auth function
        $this->auth_function = new auth_function;
        // recaptcha v2
        $this->captcha = new recaptcha_v2;
    }
}
