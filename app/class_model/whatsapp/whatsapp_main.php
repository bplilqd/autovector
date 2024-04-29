<?php

namespace model\whatsApp;

class whatsapp_main
{
    private $token = WHATSAPP_TOKEN;
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
        $str = date("c") . " | phone: " . $phone . " - ip: " . $_SERVER['REMOTE_ADDR'] . " | " . $mesage . " | #start#" . $result . "#end#\n";
        if ($phone) {
            $val = PATH . DS . 'app' . DS . 'logs' . DS . 'log_whatsapp' . DS . "log_whatsapp_" . $phone . '_' . date("d-m-Y") . ".txt";
        } else {
            $val = PATH . DS . 'app' . DS . 'logs' . DS . 'log_whatsapp' . DS . "other_" . date("d-m-Y") . ".txt";
        }
        $new = fopen($val, "a");
        fwrite($new, $str);
        fclose($new);
    }
}
