<?php

class class_mvc
{

    protected $json;
    protected $array;

    function __construct()
    {
        $this->set_parm(); // set json
        $this->parse_resource(); // decode json to array for next work
    }

    protected function parse_resource()
    {
        $json = $this->json;
        $array = json_decode($json, true);
        $this->array = $array;
        print_r($array);
    }

    protected function set_parm()
    {
        $this->json = '{"class_model":["work_class","function","set_app"],"page_view":["page_class","css","js"],"work_controller":{"work":["user","admin","edet"],"0":"other","1":"bot"}}';
    }

    // method create directorys
    protected function create_dir()
    {
    }
}

$mvc = new class_mvc;
echo "\n" . 'end_sorce_for_class_mvc';
