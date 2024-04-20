<?php

namespace controller;

class auth_controller extends main_controller
{

    protected $data; // data of auth

    function __construct()
    {
        // controller ->
        $this->set_in_controller();
        // model ->
        $this->set_in_model();
        // view ->
        $this->set_in_view();
    }

    protected function set_in_controller()
    {
        // load casses - add names for class for set autoload 
        $this->start_name_class();
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
            header("refresh:5; url=/");
        }
        // validation of user input of data
        if ($this->request) {
            $this->check_of_user_input();
        }
    }

    protected function set_in_model()
    {
        // start work for to model -> option/settings
        $this->model->set_and_setting();
    }

    protected function set_in_view()
    {
        // data transfer and set view
        $form = $this->model->auth_form->form($this->data);
        $this->view->setting_properties('content', $form);
        if (RECAPTCHA_ON) {
            // set recaptcha js to meta
            $meta = '<script src="https://www.google.com/recaptcha/api.js"></script>';
            $this->view->setting_properties('meta', '', $meta);
        }
        // default set to name of current theme
        $this->view->setting_properties('user_theme', DESIGN_THEME); // theme default
        // default set to what is the dark or light theme
        $this->view->setting_properties('data_bs_theme', MODE_THEME); // mode default
        // for print errors
        $this->view->error_print();
        // set_foot
        $this->view->set_foot($this->model->count_query);
        // include theme
        $this->view->include_theme();
    }

    protected function check_recaptcha()
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
    protected function check_of_user_input()
    {
        $request = $this->request;
        // if push button
        if ($request['auth_submit'] == 'auth_submit') {
            $captcha = $this->check_recaptcha();
            if ($captcha) {

                // validation data of user
                if ($request['phone']) {
                    if ($this->phone_validate($request['phone'])) {
                        $phone = $this->valid_phone_set($request['phone']);
                    }
                } else {
                    $this->error_manager->add_error(
                        $this->translations->get_message(
                            'auth',
                            'enter_phone'
                        )
                    );
                }

                // form handler
                $data['auth_form'] = [
                    'phone' => $phone,
                    'set_phone' => strip_tags($request['set_phone']),
                    'pass' => strip_tags($request['pass']),
                    'auth_submit' => strip_tags($request['auth_submit'])
                ];

                // sent data -> model
                $this->model->data_of_auth($data);
                // set data of user
                $this->data = $data;
            }
        }
    }

    protected function valid_phone_set($phone)
    {
        $phone_trim = preg_replace('/[^0-9]/', '', trim($phone));
        $phone_str = substr($phone_trim, -10);
        $result = preg_replace('/^[9].*/', '7' . $phone_str, $phone_str);
        return $result;
    }

    protected function phone_validate($phone)
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

    // start name class
    protected function start_name_class()
    {
        // array for model -> fuction classes
        $class_mosel_setings = ['recaptcha_v2', 'auth_function'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS . 'function' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model -> connect class
        $class_mosel_setings = ['useMysqli', 'interfaceForUseMysqli', 'forUseMysqli'];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS . 'connect' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model class
        $class_model = ['interface_auth_model', NAME_MODEL];
        $path_model = PATH . DS . 'app' . DS . 'class_model' . DS;
        $array[] = [$class_model, $path_model];

        // array for view class
        $class_view = ['interface_auth_form', 'auth_form', 'interface_auth_view', NAME_VIEW];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }
}
