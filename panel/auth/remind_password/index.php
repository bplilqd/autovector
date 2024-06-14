<?php

$name_controller = 'auth_remind_password'; // name basic of controller / NAME_CONTROLLER
$name_model = 'auth_remind_password'; // name basic of model / NAME_MODEL
$name_view = 'auth_remind_password'; // name basic ofview / NAME_VIEW

// builds a file path with the appropriate directory separator
define("DS", DIRECTORY_SEPARATOR);
// path to dir site
define("PATH", realpath(__DIR__ . DS . '..' . DS . '..' . DS . '..'));

// autoload classes
require_once PATH . DS . 'app' . DS . 'autoload.php';
// set object controller
$main = new ('controller\\' . NAME_CONTROLLER);
