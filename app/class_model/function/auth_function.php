<?php

namespace model\function;

use model\function\translations;
use controller\error\error_manager;

class auth_function{
    // object language
    protected object $translations; // lang
    protected object $error_manager; // error
    public function generateCode($length = 6)
    {
        $chars = "abcdefikmprstuvwxyz123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }
    public function create_md5_to_auth_phone($secret_key, $pass, int $phone)
    {
        if ($secret_key && $pass && $phone) {
            $generate_hash = md5("$secret_key:$pass:$phone");
            return $generate_hash;
        } else {
            $this->dependency_injection();
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'auth',
                    'no_data'
                )
            );
        }
    }
    protected function dependency_injection()
    {
        // setting error object
        if (!$this->error_manager) {
            $this->error_manager = error_manager::get_instance();
        }
        // set object for enter of language
        if (!$this->translations) {
            $this->translations = translations::getInstance();
        }
    }
}