<?php

namespace model\whatsApp;

class whatsapp_main
{
    private $token = 'aGJQpdRbS71C2TbF';
    private $url = 'https://wamm.chat/api2/';
    protected $result_json = '';
    protected $result_arr = [];

    // colection start url for request
    protected function set_url($type_method)
    {
        $url = $this->url . $type_method . '/' . $this->token . '/';
        return $url;
    }

    // sent request
    protected function conect_api($url, $type, $options = false, $phone = false, $mesage = false)
    {
        if ($options) {
            $this->result_json = file_get_contents($url, $type, $options);
        } else {
            //echo $url;
            $this->result_json = file_get_contents($url, $type);
        }
        // json decode for write to log
        $this->result_arr = json_decode($this->result_json, TRUE);
        if ($this->result_json) {
            // log
            $this->log_whatsapp($this->result_json, $phone, $mesage);
        }
    }

    // log
    private function log_whatsapp($result, $phone = false, $mesage = false)
    {
        $str = date("c") . " | ID: " . $phone . " - " . $_SERVER['REMOTE_ADDR'] . " | " . $mesage . " | ###" . $result . "###\n";
        if ($phone) {
            $val = __DIR__ . "/log_whatsapp/id_" . $phone . "_log_user" . date("-d-m-Y") . ".txt";
        } else {
            $val = __DIR__ . "/log_whatsapp/id_other_log_user" . date("-d-m-Y") . ".txt";
        }
        $new = fopen($val, "a");
        fwrite($new, $str);
        fclose($new);
    }
}
