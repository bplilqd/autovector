<?php
define("DS", DIRECTORY_SEPARATOR);
include 'create_mvc/arr_to_json_for_mvc.php';
include 'create_mvc/class_mvc.php';

use create_mvc\array\arr_to_json_for_mvc;
use create_mvc\mvc\class_mvc;

$array['app']['class_model'] = ['work_class', 'function', 'setings'];
$array['app']['page_view'] = ['page_class', 'template' => ['design' => ['css', 'js']]];
$array['app']['work_controller'] =['work' => ['user', 'admin']];
$array['app']['work_controller']['work']['auth'] = [];
$array['images'] = [];
$array['css'] = [];
$array['js'] = [];

$path = __DIR__;
$json = new arr_to_json_for_mvc($array);
$mvc = new class_mvc($json->json, $path);
