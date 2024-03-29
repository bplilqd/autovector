<?php

$name_model = 'default_model'; // name basic of model / NAME_MODEL
$name_controller = 'auth_controller'; // name basic of controller / NAME_CONTROLLER

define("PATH", '../../../..'); // path to dir site
define("DS", DIRECTORY_SEPARATOR); // builds a file path with the appropriate directory separator

require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'function' . DS . 'function.php'; // basic load function, config, class, constant and other...

set_main_class(NAME_CONTROLLER); // set controller for start work
$set_object_controller = 'controller\\'.NAME_CONTROLLER;
$main = new $set_object_controller; // set object controller

print_r($main);
