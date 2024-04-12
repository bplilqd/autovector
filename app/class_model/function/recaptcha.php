<?php

namespace model\function;

class recaptcha
{
    static $error_arr;
    public $captcha;

    public function recaptcha()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['g-recaptcha-response'])) {
                // write down an error
                $this->error_arr[] = "Error of recaptcha.";
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
                $this->error_arr[] = "Verification failed, click - I'm not a robot.";
            }
        }
    }
}
