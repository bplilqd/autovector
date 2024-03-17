<?php
require_once 'create_mvc/arr_to_json_for_mvc.php';
require_once 'create_mvc/class_mvc.php';

$array['class_model'] = ['work_class', 'function', 'set_app'];
$array['page_view'] = ['page_class', 'css', 'js'];
$array['work_controller'] = ['work' => ['user', 'admin'=>['panel','setings'=>['test']], 'edet'], 'other', 'bot'];
$array['other'] = [];


$json = new arr_to_json_for_mvc($array);
$mvc = new class_mvc($json->json);