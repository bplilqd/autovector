<?php

namespace controller\work\auth;

class auth_function{

    public $error_arr;
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
            $this->error_arr[] = __FUNCTION__ . ' not data';
        }
    }
}