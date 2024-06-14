<?php

namespace controller;

class auth_remind_password extends main_controller
{
    private $data = []; // data of auth

    public function __construct()
    {
        // controller ->
        $this->set_in_controller();
        // model ->
        $this->set_in_model();
        // view ->
        $this->set_in_view();
    }

    private function set_in_controller()
    {
        // standart methods -> set request, set hash from browser, set object of model and others...
        $this->set_standart();
        // if auth to refresh/redirect
        if ($this->hash) {
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'auth',
                    'redirection_after'
                )
            );
            header("refresh:5; url=" . SITE_URL);
        }
        // validation of user input of data
        if ($this->request) {
            $this->check_of_user_input();
        }
    }

    private function set_in_model()
    {
        // start work for to model -> option/settings
        $this->model->set_and_setting();
    }

    private function set_in_view()
    {
        // set view -> template
        $this->view = new ('view\\' . NAME_VIEW);
        // show form only if no authentication
        if (!$this->hash) {
            // data transfer and set view
            $form = $this->model->remind_password_form->form($this->data);
            $this->view->setting_properties('content', $form);
            if (RECAPTCHA_ON) {
                // set recaptcha js to meta
                $this->view->set_meta();
            }
        }
        // for print errors
        $this->view->error_print();
        // message print
        $this->view->messages_print();
        // set_foot
        $this->view->set_foot($this->model->count_request());
        // include theme
        $this->view->include_theme();
    }

    private function check_recaptcha()
    {
        if (RECAPTCHA_ON) {
            // start recaptcha for check
            $this->model->captcha->recaptcha();
            // recaptcha false / true
            $captcha = $this->model->captcha->captcha;
        } else {
            $captcha = true;
        }
        return $captcha;
    }

    // validation of user input
    private function check_of_user_input()
    {
        $request = $this->request;
        // if push button
        if ($request['auth_remind_pass'] == 'auth_remind_pass') {
            // validation data of user
            $phone = $this->validation_data_of_user($request['phone']);
            // check recaptcha
            $captcha = $this->check_recaptcha();
            if ($captcha) {
                // form handler
                $data['remind_password_form'] = [
                    'phone' => $phone,
                    'auth_remind_pass' => strip_tags($request['auth_remind_pass'])
                ];
                // sent data -> model
                $this->model->data_of_auth($data);
                // set data of user
                $this->data = $data;
            }
        }
    }

    private function validation_data_of_user($request_phone)
    {
        if ($request_phone) {
            if ($this->phone_validate($request_phone)) {
                $phone = $this->valid_phone_set($request_phone);
            }
        } else {
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'auth',
                    'enter_phone'
                )
            );
        }
        return $phone;
    }

    private function valid_phone_set($phone)
    {
        $phone_trim = preg_replace('/[^0-9]/', '', trim($phone));
        $phone_str = substr($phone_trim, -10);
        $result = preg_replace('/^[9].*/', '7' . $phone_str, $phone_str);
        return $result;
    }

    private function phone_validate($phone)
    {
        $result = (preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', trim($phone)));
        if (!$result) {
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'auth',
                    'not_correct_format_number'
                )
            );
        }
        return $result;
    }
}
