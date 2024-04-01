<?php

namespace controller\work\auth;

class auth_function{

    static $error_arr;

    public function create_md5_to_auth_phone($secret_key, $pass, int $phone)
    {
        if ($secret_key && $pass && $phone) {
            $generate_hash = md5("$secret_key:$pass:$phone");
            return $generate_hash;
        } else {
            $this->error_arr[] = __FUNCTION__ . ' not data';
        }
    }
}