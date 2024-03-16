<?php

class arr_to_json_for_mvc
{
    public $json;
    function __construct($array)
    {
        $json = json_encode($array);
        $this->json = $json;
    }
}

$array['class_model'] = ['work_class', 'function', 'set_app'];
$array['page_view'] = ['page_class', 'css', 'js'];
$array['work_controller'] = ['work' => ['user', 'admin', 'edet'], 'other', 'bot'];

$json = new arr_to_json_for_mvc($array);
echo $json->json;
