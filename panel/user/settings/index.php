<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$name_model = 'user_settings'; // name basic of model / NAME_MODEL
$name_controller = 'user_settings'; // name basic of controller / NAME_CONTROLLER
$name_view = 'user_settings'; // name basic ofview / NAME_VIEW

define("PATH", realpath(__DIR__.'/../../..')); // path to dir site
define("DS", DIRECTORY_SEPARATOR); // builds a file path with the appropriate directory separator

require_once PATH . DS . 'app' . DS . 'model' . DS . 'function' . DS . 'function.php'; // basic load function, config, class, constant and other...

set_main_class(NAME_CONTROLLER); // set controller for start work
$main = new ('controller\\' . NAME_CONTROLLER); // set object controller

//print_r($_SERVER);
