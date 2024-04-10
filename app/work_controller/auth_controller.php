<?php

namespace controller;

class auth_controller extends main_controller
{

    protected $data; // data of auth

    function __construct()
    {
        // controller ->
        // load casses - add names for class for set autoload 
        $this->start_name_class();
        // standart methods -> set request, set hash from browser, set object of model and others...
        $this->set_standart();
        // if auth to refresh/redirect
        if ($this->hash) {
            $this->error_arr[] = 'As long as there is authorization, there will be a redirection after 5 seconds';
            header("refresh:5; url=../../../..");
        }

        // model ->
        // validation of user input of data
        if ($this->request) {
            $this->check_of_user_input();
        }
        // sending error to model
        if ($this->error_arr) {
            $this->model->error($this->error_arr, 'controller');
        }
        // start work for to model -> option/settings
        $this->model->set_and_setting();

        // view ->
        // data transfer and set view
        $this->view->content = $this->model->auth_form->form($this->data);
        // default set to name of current theme
        $this->view->user_theme = DESIGN_THEME; // theme default
        // default set to what is the dark or light theme
        $this->view->data_bs_theme = MODE_THEME; // mode default
        // for print errors
        $this->view->error_print($this->model->error_arr);
        // set_foot
        $this->view->set_foot($this->model->count_query);
        // include theme
        $this->view->include_theme();
    }

    // validation of user input
    protected function check_of_user_input()
    {
        $request = $this->request;
        // if push button
        if ($request['auth_submit'] == 'auth_submit') {

            // validation data of user
            if ($request['phone']) {
                if ($this->phone_validate($request['phone'])) {
                    $phone = $this->valid_phone_set($request['phone']);
                }
            } else {
                $this->error_arr[] = 'Enter phone number.';
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
            $this->error_arr[] = "Not correct format number phone, try example +79006003070 or 89006003070.";
        }
        return $result;
    }

    // start name class
    protected function start_name_class()
    {
        // array for controller/work -> auth classes
        $class_mosel_setings = ['auth_function'];
        $path_model = PATH . DS . 'app' . DS . 'work_controller' . DS . 'work' . DS . 'auth' . DS;
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
        $class_view = ['interface_auth_form', 'auth_form', 'interface_set_theme', NAME_VIEW];
        $path_model = PATH . DS . 'app' . DS . 'page_view' . DS;
        $array[] = [$class_view, $path_model];

        // autoload class
        $this->autoload_class($array);
    }
}
