<?php

$name_model = 'default_model'; // name basic of model
$name_controller = 'default_controller'; // name basic of controller

define("PATH", __DIR__); // path to dir site
define("DS", DIRECTORY_SEPARATOR); // builds a file path with the appropriate directory separator

require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'function' . DS . 'function.php'; // basic load function, config, class, constant and other...

set_main_class($name_controller); // set controller for start work
$set_object_controller = 'work\\'.$name_controller;
$main = new $set_object_controller; // set object controller

print_r($main);
