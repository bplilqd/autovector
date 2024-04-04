<?php

namespace controller;

class auth_controller extends main_controller
{

    function __construct()
    {
        // set request
        $this->set_request();
        // load casses - add names for class for set autoload 
        $this->start_name_class();
        // set object of model
        $this->set_object_model();
        // validation of user input of data
        if ($this->request) {
            $this->check_of_user_input();
        }
        // start work for wiew to model -> option/settings
        $this->model->set_and_settin_view();
        // sending error to model
        if ($this->error_arr) {
            $this->model->error($this->error_arr, 'controller');
        }
        print_r($this->model->error_arr);
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
            }

            // form handler
            $data['auth_form'] = [
                'phone' => $phone,
                'set_phone' => strip_tags($request['set_phone']),
                'pass' => strip_tags($request['pass']),
                'auth_submit' => strip_tags($request['auth_submit'])
            ];

            // error
            $data['error_arr'][] = $this->error_arr;

            // sent data -> model
            $this->model->data_of_auth($data);
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
            $this->error_arr[] = "Не корректный формат телефона, попробуйте такого вида +79006003070 или 89006003070.";
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
        $class_model = [NAME_MODEL];
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
