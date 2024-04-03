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
        $this->check_of_user_input();
        // start work to wiew -> option/settings
        $this->model->set_and_settin_view();
    }

    // validation of user input
    protected function check_of_user_input()
    {
        $request = $this->request;
        if ($request['auth_submit'] == 'auth_submit') {

            // validation data of user
            // ...?

            // form handler
            $data['auth_form'] = [
                'phone' => $request['phone'],
                'pass' => $request['pass']
            ];
            // sent data
            $this->model->data_of_auth($data);
        }
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
