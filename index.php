<?php

$name_model = 'default_model'; // name basic of model / NAME_MODEL
$name_controller = 'default_controller'; // name basic of controller / NAME_CONTROLLER
$name_view = 'default_view'; // name basic ofview / NAME_VIEW

// builds a file path with the appropriate directory separator
define("DS", DIRECTORY_SEPARATOR);
// path to dir site
define("PATH", __DIR__);

// autoload classes
require_once PATH . DS . 'app' . DS . 'autoload.php';
// set object controller
$main = new ('controller\\' . NAME_CONTROLLER);
