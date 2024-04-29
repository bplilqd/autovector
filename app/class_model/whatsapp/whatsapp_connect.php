<?php

namespace model\whatsApp;

use controller\error\error_manager;

class whatsapp_connect extends whatsapp_error implements interface_whatsapp
{
    protected object $error_manager; // error

    // API Check WhatsApp availability by phone number
    // Request GET: https://wamm.chat/api2/check_phone/token/?phone=number
    public function check_phone($phone)
    {
        $type_method = __FUNCTION__;
        $url = $this->set_url($type_method)
            . '?phone=' . $phone;
        // request
        $this->conect_api($url, FALSE, FALSE, $phone);
        // check error
        $this->check_err_result($type_method);
        // setting error object
        $this->error();
        if (!$this->error_manager->has_errors) {
            // check result phone
            $result = $this->result_check_phone();
            return $result;
        }
    }

    // Adding and updating contacts
    // Request GET: https://wamm.chat/api2/contact_to/token/?phone=number&name=name&info=note&email=email&web=url
    public function contact_to($phone, $name, $info = false, $email = false, $web = false)
    {
        $type_method = __FUNCTION__;
        $url = $this->set_url($type_method)
            . '?phone=' . $phone . ''
            . '&name=' . urlencode($name) . ''
            . '&info=' . urlencode($info) . ''
            . '&email=' . $email . ''
            . '&web=' . $web;
        // request
        $this->conect_api($url, FALSE, FALSE, $phone, $name . ' ' . $info . ' ' . $email . ' ' . $web);
        // check error
        $this->check_err_result($type_method);
    }

    // Sent mesages
    // Request GET: https://wamm.chat/api2/msg_to/token/?phone=number&text=text of mesage
    public function msg_to($phone, $message)
    {
        $type_method = __FUNCTION__;
        $url = $this->set_url($type_method)
            . '?phone=' . $phone . '&text=' . urlencode($message);
        // request
        $this->conect_api($url, FALSE, FALSE, $phone, $message);
        // check error
        $this->check_err_result($type_method);
    }

    private function error()
    {
        // setting error object
        $this->error_manager = error_manager::get_instance();
    }
    
    private function check_err_result($type_method)
    {
        $array = $this->result_arr;
        if ($array['err']) {
            // setting error object
            $this->error();
            // looks for a function name like err_for_msg_to where for example $type_method = 'msg_to'
            $name_fun = 'err_for_' . $type_method;
            $error_print = $this->$name_fun($array['err']);
            // add err for print
            $this->error_manager->add_error($error_print);
        }
    }

    // check the result of checking whether WhatsApp is available
    private function result_check_phone()
    {
        $result = false;
        foreach ($this->result_arr as $key => $value) {
            if ($key == 'result') {
                if ($value == 'exists') {
                    $result = true;
                }
            }
        }
        return $result;
    }
}
