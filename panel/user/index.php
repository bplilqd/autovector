<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$name_model = 'user_model'; // name basic of model / NAME_MODEL
$name_controller = 'user_controller'; // name basic of controller / NAME_CONTROLLER
$name_view = 'user_view'; // name basic ofview / NAME_VIEW

// builds a file path with the appropriate directory separator
define("DS", DIRECTORY_SEPARATOR);
// path to dir site
define("PATH", realpath(__DIR__ . DS . '..' . DS . '..'));

// autoload classes
require_once PATH . DS . 'app' . DS . 'autoload.php';
// set object controller
$main = new ('controller\\' . NAME_CONTROLLER);
