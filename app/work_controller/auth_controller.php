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
        // set objects of model
        $this->set_object();
        // validation of user input
        $this->check_of_user_input();
        // work to wiew -> option/settings
        $this->model->set_and_settin_view();
    }

    // validation of user input
    protected function check_of_user_input()
    {
        // validation data of user
        // ...?

        // form handler
        $request = $this->request;
        //$request['phone'] = 79214604140;
        if ($request) {
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
