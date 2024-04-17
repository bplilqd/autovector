<?php

// create: https://www.google.com/recaptcha/admin/create

namespace model\function;

use model\function\translations;

class recaptcha_v2
{
    public $error_arr;
    public bool $captcha = false;
    protected object $translations; // lang

    public function recaptcha()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // set object for enter of language
            $this->translations = translations::getInstance();
            
            if (empty($_POST['g-recaptcha-response'])) {
                // write down an error
                $this->error_arr[] = $this->translations->get_message('auth', 'error_captcha');
            }

            $url = 'https://www.google.com/recaptcha/api/siteverify';

            $secret = RECAPTCHA_INSIDE;
            $recaptcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];

            $url_data = $url . '?secret=' . $secret . '&response=' . $recaptcha . '&remoteip=' . $ip;
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url_data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $res = curl_exec($curl);
            curl_close($curl);

            $result = json_decode($res);

            if ($result->success) {
                $this->captcha = true;
            } else {
                // write down an error
                $this->error_arr[] = $this->translations->get_message('auth', 'verification_failed');
            }
        }
    }
}
