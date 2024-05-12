<?php

// create: https://www.google.com/recaptcha/admin/create

namespace model\function;

use model\function\translations;
use controller\error\error_manager;

class recaptcha_v2
{
    public bool $captcha = false;
    protected object $translations; // lang
    protected object $error_manager; // error

    public function recaptcha()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // setting error object
            $this->error_manager = error_manager::get_instance();
            // set object for enter of language
            $this->translations = translations::getInstance();

            if (empty($_POST['g-recaptcha-response'])) {
                // write down an error
                $this->error_manager->add_error(
                    $this->translations->get_message(
                        'auth',
                        'error_captcha'
                    )
                );
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
                $this->error_manager->add_error(
                    $this->translations->get_message(
                        'auth',
                        'verification_failed'
                    )
                );
            }
        }
    }
}
