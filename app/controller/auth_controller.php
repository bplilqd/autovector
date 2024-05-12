<?php

namespace controller;

class auth_controller extends main_controller
{

    protected $data = []; // data of auth
    private $hash_captcha = 600;
    private $path_set_cookie = DS . 'panel' . DS . 'auth' . DS;

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
            $form = $this->model->auth_form->form($this->data);
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

    private function create_md5_to_auth_phone($secret_key, int $phone)
    {
        if ($secret_key && $phone) {
            $date = date('d-m-Y');
            $generate_hash = md5("$secret_key:$date:$phone");
            return $generate_hash;
        } else {
            $this->error_manager->add_error(
                __METHOD__ . ' -> ' .
                    $this->translations->get_message(
                        'auth',
                        'no_data'
                    )
            );
        }
    }
    // validation of user input
    private function check_of_user_input()
    {
        $request = $this->request;
        // if push button
        if ($request['auth_submit'] == 'auth_submit') {
            // validation data of user
            $phone = $this->validation_data_of_user($request['phone']);
            // check recaptcha
            $captcha = $this->check_recaptcha();
            if ($captcha) {
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

    // start name class
    private function start_name_class()
    {
        // array for model -> whatsapp class
        $class_model = ['interface_whatsapp', 'whatsapp_main', 'whatsapp_error', 'whatsapp_connect'];
        $path_model = PATH . DS . 'app' . DS . 'model' . DS . 'whatsapp' . DS;
        $array[] = [$class_model, $path_model];

        // array for view -> form
        $class_view_form = ['interface_form', 'form', 'auth_form'];
        $path_model = PATH . DS . 'app' . DS . 'view' . DS . 'form' . DS;
        $array[] = [$class_view_form, $path_model];

        // array for model -> fuction classes
        $class_mosel_setings = ['recaptcha_v2', 'auth_function'];
        $path_model = PATH . DS . 'app' . DS . 'model' . DS . 'function' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model -> connect class
        $class_mosel_setings = ['useMysqli', 'interfaceForUseMysqli', 'forUseMysqli'];
        $path_model = PATH . DS . 'app' . DS . 'model' . DS . 'connect' . DS;
        $array[] = [$class_mosel_setings, $path_model];

        // array for model class
        $class_model = ['interface_auth_model', NAME_MODEL];
        $path_model = PATH . DS . 'app' . DS . 'model' . DS;
        $array[] = [$class_model, $path_model];

        // array for view class
        $class_view = ['interface_auth', 'interface_view', NAME_VIEW];
        $path_model = PATH . DS . 'app' . DS . 'view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }
}
