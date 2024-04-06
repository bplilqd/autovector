<?php

$name_model = 'default_model'; // name basic of model / NAME_MODEL
$name_controller = 'default_controller'; // name basic of controller / NAME_CONTROLLER
$name_view = 'default_view'; // name basic ofview / NAME_VIEW

define("PATH", __DIR__); // path to dir site
define("DS", DIRECTORY_SEPARATOR); // builds a file path with the appropriate directory separator

require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'function' . DS . 'function.php'; // basic load function, config, class, constant and other...

set_main_class(NAME_CONTROLLER); // set controller for start work
$main = new ('controller\\' . NAME_CONTROLLER); // set object controller

//print_r($main);