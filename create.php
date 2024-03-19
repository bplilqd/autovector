<?php
define("DS", DIRECTORY_SEPARATOR);
require_once 'create_mvc/arr_to_json_for_mvc.php';
require_once 'create_mvc/class_mvc.php';

$array['app']['class_model'] = ['work_class', 'function', 'setings'];
$array['app']['page_view'] = ['page_class', 'template' => ['design' => ['css', 'js']]];
$array['app']['work_controller'] =['work' => ['auth', 'user', 'admin']];
$array['images'] = [];
$array['css'] = [];
$array['js'] = [];

$path = __DIR__;
$json = new arr_to_json_for_mvc($array);
$mvc = new class_mvc($json->json, $path);
